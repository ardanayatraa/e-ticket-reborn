<?php

namespace App\Http\Controllers;

use App\Jobs\SendTicketJob;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function payment(Transaksi $transaksi)
    {
        // Implementation for payment page if needed
        return view('booking.payment', compact('transaksi'));
    }

    public function paymentSuccess(Request $request)
    {
        try {
            $result = $request->all();

            Log::info('Booking payment success callback received', $result);

            // Find transaction by order_id
            $orderId = $result['order_id'] ?? null;
            if (!$orderId) {
                return response()->json(['message' => 'Order ID not found'], 400);
            }

            $transaksi = Transaksi::where('order_id', $orderId)->first();
            if (!$transaksi) {
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // --- UPDATE: Update semua transaksi terkait booking multiple mobil ---
            $pelangganId = $transaksi->pelanggan_id;
            $paketWisataId = $transaksi->paketwisata_id;
            $createdAt = $transaksi->created_at;
            $tanggalKeberangkatan = $transaksi->ketersediaan ? $transaksi->ketersediaan->tanggal_keberangkatan : null;

            $relatedTransaksi = collect();
            if ($tanggalKeberangkatan) {
                // Ambil semua transaksi yang pending, user & paket & tanggal sama, dibuat dalam 1 menit
                $relatedTransaksi = Transaksi::where('pelanggan_id', $pelangganId)
                    ->where('paketwisata_id', $paketWisataId)
                    ->where('transaksi_status', 'pending')
                    ->whereHas('ketersediaan', function($q) use ($tanggalKeberangkatan) {
                        $q->whereDate('tanggal_keberangkatan', $tanggalKeberangkatan);
                    })
                    ->whereBetween('created_at', [
                        $createdAt->copy()->subMinute(),
                        $createdAt->copy()->addMinute()
                    ])
                    ->get();
            }

            // Jika tidak ketemu, update transaksi utama saja
            if ($relatedTransaksi->isEmpty()) {
                $relatedTransaksi = collect([$transaksi]);
            }

            // Hitung deposit per transaksi jika gross_amount ada
            $depositPerTransaksi = null;
            if (isset($result['gross_amount']) && $relatedTransaksi->count() > 0) {
                $depositPerTransaksi = $result['gross_amount'] / $relatedTransaksi->count();
            }

            foreach ($relatedTransaksi as $trx) {
                $trx->update([
                    'transaksi_status' => 'paid',
                    'deposit' => $depositPerTransaksi !== null ? $depositPerTransaksi : ($result['gross_amount'] ?? $trx->total_transaksi),
                ]);
                SendTicketJob::dispatch($trx);
            }

            return response()->json([
                'success' => true,
                'message' => 'Payment processed successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Error processing booking payment success: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing payment'
            ], 500);
        }
    }

    public function callback(Request $request)
    {
        try {
            $serverKey = config('midtrans.server_key');
            $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

            if ($hashed !== $request->signature_key) {
                Log::warning('Invalid signature in booking callback', $request->all());
                return response()->json(['message' => 'Invalid signature'], 400);
            }

            $transaksi = Transaksi::where('order_id', $request->order_id)->first();
            if (!$transaksi) {
                Log::warning('Transaction not found in booking callback', ['order_id' => $request->order_id]);
                return response()->json(['message' => 'Transaction not found'], 404);
            }

            // Update based on transaction status
            switch ($request->transaction_status) {
                case 'capture':
                case 'settlement':
                    $transaksi->update([
                        'transaksi_status' => 'paid',
                        'deposit' => $request->gross_amount,
                    ]);

                    // Points will be added automatically by observer when status changes to 'paid'
                    break;

                case 'pending':
                    $transaksi->update(['transaksi_status' => 'pending']);
                    break;

                case 'deny':
                case 'expire':
                case 'cancel':
                    $transaksi->update(['transaksi_status' => 'cancelled']);

                    // Return points if they were used
                    if ($transaksi->note && strpos($transaksi->note, 'Menggunakan') !== false) {
                        // Extract points from note and return them
                        preg_match('/Menggunakan (\d+) poin/', $transaksi->note, $matches);
                        if (isset($matches[1])) {
                            $pointsToReturn = (int) $matches[1];
                            $pelanggan = $transaksi->pelanggan;
                            if ($pelanggan) {
                                $pelanggan->increment('points', $pointsToReturn);
                                Log::info('Points returned due to cancelled transaction', [
                                    'pelanggan_id' => $pelanggan->pelanggan_id,
                                    'points_returned' => $pointsToReturn,
                                    'transaction_id' => $transaksi->transaksi_id
                                ]);
                            }
                        }
                    }
                    break;
            }

            Log::info('Booking callback processed successfully', [
                'order_id' => $request->order_id,
                'status' => $request->transaction_status
            ]);

            return response()->json(['message' => 'OK']);

        } catch (\Exception $e) {
            Log::error('Error in booking callback: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['message' => 'Error'], 500);
        }
    }
}
