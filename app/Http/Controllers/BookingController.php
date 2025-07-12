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

            // Update transaction status
            $transaksi->update([
                'transaksi_status' => 'paid',
                'deposit' => $result['gross_amount'] ?? $transaksi->total_transaksi,
            ]);

                SendTicketJob::dispatch($transaksi);

            // Points will be added automatically by observer when status changes to 'paid'

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
