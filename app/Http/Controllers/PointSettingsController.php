<?php

namespace App\Http\Controllers;

use App\Models\PointSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class PointSettingsController extends Controller
{
    /**
     * Display the point settings page
     */
    public function index()
    {
        try {
            $settings = PointSetting::all();

            // Ensure default settings exist
            $this->ensureDefaultSettings();

            // Reload settings after ensuring defaults
            $settings = PointSetting::all();

            return view('point-settings.index', compact('settings'));
        } catch (\Exception $e) {
            Log::error('Error loading point settings: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'Gagal memuat pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Update point settings
     */
    public function update(Request $request)
    {
        // Validation rules
        $validated = $request->validate([
            'points_per_transaction' => [
                'required',
                'integer',
                'min:10000',
                'max:10000000'
            ],
            'points_earned_per_transaction' => [
                'required',
                'integer',
                'min:1',
                'max:1000'
            ],
            'points_for_discount' => [
                'required',
                'integer',
                'min:1',
                'max:1000'
            ],
            'discount_per_points' => [
                'required',
                'integer',
                'min:1000',
                'max:1000000'
            ],
        ], [
            // Custom error messages
            'points_per_transaction.required' => 'Rupiah per poin harus diisi',
            'points_per_transaction.min' => 'Rupiah per poin minimal Rp 10.000',
            'points_per_transaction.max' => 'Rupiah per poin maksimal Rp 10.000.000',

            'points_earned_per_transaction.required' => 'Poin per transaksi harus diisi',
            'points_earned_per_transaction.min' => 'Poin per transaksi minimal 1',
            'points_earned_per_transaction.max' => 'Poin per transaksi maksimal 1000',

            'points_for_discount.required' => 'Poin untuk diskon harus diisi',
            'points_for_discount.min' => 'Poin untuk diskon minimal 1',
            'points_for_discount.max' => 'Poin untuk diskon maksimal 1000',

            'discount_per_points.required' => 'Diskon per poin harus diisi',
            'discount_per_points.min' => 'Diskon per poin minimal Rp 1.000',
            'discount_per_points.max' => 'Diskon per poin maksimal Rp 1.000.000',
        ]);

        try {
            DB::beginTransaction();

            // Update each setting
            PointSetting::setValue('points_per_transaction', $validated['points_per_transaction']);
            PointSetting::setValue('points_earned_per_transaction', $validated['points_earned_per_transaction']);
            PointSetting::setValue('points_for_discount', $validated['points_for_discount']);
            PointSetting::setValue('discount_per_points', $validated['discount_per_points']);

            DB::commit();

            // Log the update
            Log::info('Point settings updated', [
                'user_id' => auth()->id(),
                'settings' => $validated,
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating point settings: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $validated,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->route('point-settings.index')
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Get point calculation preview (AJAX endpoint)
     */
    public function preview(Request $request)
    {
        try {
            $pointsPerTransaction = (int) $request->input('points_per_transaction', 500000);
            $pointsEarned = (int) $request->input('points_earned_per_transaction', 5);
            $pointsForDiscount = (int) $request->input('points_for_discount', 10);
            $discountPerPoints = (int) $request->input('discount_per_points', 10000);

            // Calculate earned points for different transaction amounts
            $calculations = [];
            $transactionAmounts = [500000, 1000000, 2000000, 5000000];

            foreach ($transactionAmounts as $amount) {
                $earnedPoints = floor($amount / $pointsPerTransaction) * $pointsEarned;
                $calculations[] = [
                    'transaction_amount' => $amount,
                    'earned_points' => $earnedPoints,
                    'formatted_amount' => 'Rp ' . number_format($amount, 0, ',', '.')
                ];
            }

            // Calculate discounts for different point amounts
            $discounts = [];
            $pointAmounts = [10, 20, 50, 100];

            foreach ($pointAmounts as $points) {
                $discountAmount = floor($points / $pointsForDiscount) * $discountPerPoints;
                $discounts[] = [
                    'points' => $points,
                    'discount_amount' => $discountAmount,
                    'formatted_discount' => 'Rp ' . number_format($discountAmount, 0, ',', '.')
                ];
            }

            return response()->json([
                'success' => true,
                'calculations' => $calculations,
                'discounts' => $discounts,
                'settings' => [
                    'points_per_transaction' => $pointsPerTransaction,
                    'points_earned' => $pointsEarned,
                    'points_for_discount' => $pointsForDiscount,
                    'discount_per_points' => $discountPerPoints
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error calculating preview: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset settings to default values
     */
    public function reset()
    {
        try {
            DB::beginTransaction();

            $defaultSettings = [
                'points_per_transaction' => 500000,
                'points_earned_per_transaction' => 5,
                'points_for_discount' => 10,
                'discount_per_points' => 10000
            ];

            foreach ($defaultSettings as $key => $value) {
                PointSetting::setValue($key, $value);
            }

            DB::commit();

            Log::info('Point settings reset to default', [
                'user_id' => auth()->id(),
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil direset ke nilai default!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error resetting point settings: ' . $e->getMessage());

            return redirect()->route('point-settings.index')
                ->with('error', 'Gagal mereset pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Ensure default settings exist in database
     */
    private function ensureDefaultSettings()
    {
        $defaultSettings = [
            'points_per_transaction' => 500000,
            'points_earned_per_transaction' => 5,
            'points_for_discount' => 10,
            'discount_per_points' => 10000
        ];

        foreach ($defaultSettings as $key => $defaultValue) {
            PointSetting::firstOrCreate(
                ['key' => $key],
                ['value' => $defaultValue]
            );
        }
    }
}
