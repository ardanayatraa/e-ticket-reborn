<?php

namespace App\Http\Controllers;

use App\Models\MemberPayment;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:pelanggan');
    }

    public function upgrade(Request $request)
    {
        $pelanggan = Auth::guard('pelanggan')->user();

        if ($pelanggan->is_member) {
            return response()->json(['error' => 'Anda sudah menjadi member!'], 400);
        }

        // Cek apakah ada pembayaran pending
        $pendingPayment = MemberPayment::where('pelanggan_id', $pelanggan->pelanggan_id)
            ->where('payment_status', 'pending')
            ->first();

        if ($pendingPayment) {
            $orderId = $pendingPayment->order_id;
        } else {
            // Buat order baru
            $orderId = 'MEMBER-' . $pelanggan->pelanggan_id . '-' . time();

            MemberPayment::create([
                'pelanggan_id' => $pelanggan->pelanggan_id,
                'order_id' => $orderId,
                'amount' => 25000
            ]);
        }

        // Setup Midtrans
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => 25000,
            ],
            'customer_details' => [
                'first_name' => $pelanggan->nama_pemesan,
                'email' => $pelanggan->email,
                'phone' => $pelanggan->nomor_whatsapp,
            ],
            'item_details' => [
                [
                    'id' => 'MEMBER_UPGRADE',
                    'price' => 25000,
                    'quantity' => 1,
                    'name' => 'Upgrade Member Bali Om Tours'
                ]
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            if ($request->wantsJson()) {
                return response()->json(['snap_token' => $snapToken]);
            }

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal membuat pembayaran: ' . $e->getMessage()], 500);
        }
    }

    public function callback(Request $request)
    {
        dd($request->all());
        // Setup Midtrans config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            // Get notification from Midtrans
            $notification = new \Midtrans\Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? 'accept';
            $paymentType = $notification->payment_type ?? '';
            $transactionId = $notification->transaction_id ?? '';
            $grossAmount = $notification->gross_amount ?? 0;

            Log::info('Member Payment Callback', [
                'order_id' => $orderId,
                'transaction_status' => $transactionStatus,
                'fraud_status' => $fraudStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $transactionId,
                'gross_amount' => $grossAmount
            ]);

            // Find member payment record
            $memberPayment = MemberPayment::where('order_id', $orderId)->first();

            if (!$memberPayment) {
                Log::error('Member payment not found for order_id: ' . $orderId);
                return response()->json(['status' => 'error', 'message' => 'Payment record not found'], 404);
            }

            // Process based on transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'challenge') {
                    // Payment is challenged, wait for manual review
                    $memberPayment->update([
                        'payment_status' => 'challenge',
                        'payment_type' => $paymentType,
                        'transaction_id' => $transactionId,
                        'midtrans_response' => $notification->getResponse()
                    ]);

                    Log::info('Member payment challenged: ' . $orderId);
                } else if ($fraudStatus == 'accept') {
                    // Payment successful
                    $memberPayment->update([
                        'payment_status' => 'success',
                        'payment_type' => $paymentType,
                        'transaction_id' => $transactionId,
                        'midtrans_response' => $notification->getResponse()
                    ]);

                    // Upgrade to member
                    $pelanggan = $memberPayment->pelanggan;
                    $pelanggan->becomeMember();

                    Log::info('Member upgrade successful for pelanggan_id: ' . $pelanggan->pelanggan_id);
                }
            } else if ($transactionStatus == 'settlement') {
                // Payment settled (for bank transfer, etc.)
                $memberPayment->update([
                    'payment_status' => 'success',
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId,
                    'midtrans_response' => $notification->getResponse()
                ]);

                // Upgrade to member
                $pelanggan = $memberPayment->pelanggan;
                $pelanggan->becomeMember();

                Log::info('Member upgrade successful (settlement) for pelanggan_id: ' . $pelanggan->pelanggan_id);
            } else if ($transactionStatus == 'pending') {
                // Payment pending
                $memberPayment->update([
                    'payment_status' => 'pending',
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId,
                    'midtrans_response' => $notification->getResponse()
                ]);

                Log::info('Member payment pending: ' . $orderId);
            } else if ($transactionStatus == 'deny') {
                // Payment denied
                $memberPayment->update([
                    'payment_status' => 'failed',
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId,
                    'midtrans_response' => $notification->getResponse()
                ]);

                Log::info('Member payment denied: ' . $orderId);
            } else if ($transactionStatus == 'expire') {
                // Payment expired
                $memberPayment->update([
                    'payment_status' => 'expired',
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId,
                    'midtrans_response' => $notification->getResponse()
                ]);

                Log::info('Member payment expired: ' . $orderId);
            } else if ($transactionStatus == 'cancel') {
                // Payment cancelled
                $memberPayment->update([
                    'payment_status' => 'cancelled',
                    'payment_type' => $paymentType,
                    'transaction_id' => $transactionId,
                    'midtrans_response' => $notification->getResponse()
                ]);

                Log::info('Member payment cancelled: ' . $orderId);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Member Payment Callback Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function manualSuccess(Request $request)
{
    $result = $request->all();
    $orderId = $result['order_id'] ?? null;

    if (!$orderId) {
        return response()->json(['message' => 'Order ID tidak ditemukan'], 400);
    }

    $memberPayment = MemberPayment::where('order_id', $orderId)->first();

    if (!$memberPayment) {
        return response()->json(['message' => 'Pembayaran tidak ditemukan'], 404);
    }

    // Update payment dan upgrade member
    $memberPayment->update([
        'payment_status' => 'success',
        'payment_type' => $result['payment_type'] ?? 'unknown',
        'transaction_id' => $result['transaction_id'] ?? '',
        'midtrans_response' => json_encode($result)
    ]);

    $pelanggan = Auth::guard('pelanggan')->user();
    $pelanggan->becomeMember();

    return response()->json(['message' => 'Berhasil di-upgrade menjadi member']);
}

}
