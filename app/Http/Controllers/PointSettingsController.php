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
            $settings = PointSetting::orderBy('minimum_transaksi', 'asc')->get();
            return view('point-settings.index', compact('settings'));
        } catch (\Exception $e) {
            Log::error('Error loading point settings: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Gagal memuat pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new point setting
     */
    public function create()
    {
        return view('point-settings.create');
    }

    /**
     * Store a newly created point setting
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_season_point' => 'required|string|max:255',
            'minimum_transaksi' => 'required|integer|min:10000',
            'jumlah_point_diperoleh' => 'required|integer|min:1',
            'harga_satuan_point' => 'required|integer|min:1000',
            'is_active' => 'boolean',
        ], [
            'nama_season_point.required' => 'Nama season harus diisi',
            'minimum_transaksi.required' => 'Minimum transaksi harus diisi',
            'minimum_transaksi.min' => 'Minimum transaksi minimal Rp 10.000',
            'jumlah_point_diperoleh.required' => 'Jumlah point diperoleh harus diisi',
            'jumlah_point_diperoleh.min' => 'Jumlah point diperoleh minimal 1',
            'harga_satuan_point.required' => 'Harga satuan point harus diisi',
            'harga_satuan_point.min' => 'Harga satuan point minimal Rp 1.000',
        ]);

        try {
            DB::beginTransaction();

            // If this setting is being created as active, deactivate all others
            if (isset($validated['is_active']) && $validated['is_active']) {
                PointSetting::where('is_active', true)->update(['is_active' => false]);
            }

            PointSetting::create($validated);

            DB::commit();

            Log::info('Point setting created', [
                'user_id' => auth()->id(),
                'setting' => $validated,
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error creating point setting: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request_data' => $validated,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal menambahkan pengaturan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified point setting
     */
    public function edit($id)
    {
        try {
            $setting = PointSetting::findOrFail($id);
            return view('point-settings.edit', compact('setting'));
        } catch (\Exception $e) {
            Log::error('Error loading point setting for edit: ' . $e->getMessage());
            return redirect()->route('point-settings.index')
                ->with('error', 'Pengaturan tidak ditemukan');
        }
    }

    /**
     * Update the specified point setting
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_season_point' => 'required|string|max:255',
            'minimum_transaksi' => 'required|integer|min:10000',
            'jumlah_point_diperoleh' => 'required|integer|min:1',
            'harga_satuan_point' => 'required|integer|min:1000',
            'is_active' => 'boolean',
        ], [
            'nama_season_point.required' => 'Nama season harus diisi',
            'minimum_transaksi.required' => 'Minimum transaksi harus diisi',
            'minimum_transaksi.min' => 'Minimum transaksi minimal Rp 10.000',
            'jumlah_point_diperoleh.required' => 'Jumlah point diperoleh harus diisi',
            'jumlah_point_diperoleh.min' => 'Jumlah point diperoleh minimal 1',
            'harga_satuan_point.required' => 'Harga satuan point harus diisi',
            'harga_satuan_point.min' => 'Harga satuan point minimal Rp 1.000',
        ]);

        try {
            DB::beginTransaction();

            $setting = PointSetting::findOrFail($id);
            
            // If this setting is being updated to active, deactivate all others
            if (isset($validated['is_active']) && $validated['is_active']) {
                PointSetting::where('point_id', '!=', $id)
                    ->where('is_active', true)
                    ->update(['is_active' => false]);
            }
            
            $setting->update($validated);

            DB::commit();

            Log::info('Point setting updated', [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'setting' => $validated,
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error updating point setting: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'request_data' => $validated,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified point setting
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $setting = PointSetting::findOrFail($id);
            $setting->delete();

            DB::commit();

            Log::info('Point setting deleted', [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error deleting point setting: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->route('point-settings.index')
                ->with('error', 'Gagal menghapus pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Toggle active status of a point setting
     * Only one point setting can be active at a time
     */
    public function toggleActive($id)
    {
        try {
            DB::beginTransaction();

            $setting = PointSetting::findOrFail($id);
            
            if ($setting->is_active) {
                // If currently active, deactivate it
                $setting->update(['is_active' => false]);
                $status = 'dinonaktifkan';
            } else {
                // If currently inactive, activate it and deactivate all others
                // First, deactivate all other settings
                PointSetting::where('point_id', '!=', $id)->update(['is_active' => false]);
                
                // Then activate this setting
                $setting->update(['is_active' => true]);
                $status = 'diaktifkan';
            }

            DB::commit();

            Log::info('Point setting status toggled', [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'new_status' => $setting->is_active,
                'timestamp' => now()
            ]);

            return redirect()->route('point-settings.index')
                ->with('success', "Pengaturan poin berhasil {$status}!");

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error toggling point setting status: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'setting_id' => $id,
                'error' => $e->getTraceAsString()
            ]);

            return redirect()->route('point-settings.index')
                ->with('error', 'Gagal mengubah status pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Get point calculation preview (AJAX endpoint)
     */
    public function preview(Request $request)
    {
        try {
            $transactionAmount = (int) $request->input('transaction_amount', 1000000);
            
            // Get applicable setting for this transaction amount
            $setting = PointSetting::getSettingByTransactionAmount($transactionAmount);
            
            if (!$setting) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada pengaturan yang sesuai untuk jumlah transaksi ini'
                ]);
            }

            // Calculate earned points
            $earnedPoints = PointSetting::calculateEarnedPoints($transactionAmount);
            
            // Calculate possible discounts
            $discounts = [];
            $pointAmounts = [10, 20, 50, 100];

            foreach ($pointAmounts as $points) {
                $discountAmount = PointSetting::calculateDiscount($points);
                $discounts[] = [
                    'points' => $points,
                    'discount_amount' => $discountAmount,
                    'formatted_discount' => 'Rp ' . number_format($discountAmount, 0, ',', '.')
                ];
            }

            return response()->json([
                'success' => true,
                'setting' => [
                    'nama_season_point' => $setting->nama_season_point,
                    'minimum_transaksi' => $setting->minimum_transaksi,
                    'jumlah_point_diperoleh' => $setting->jumlah_point_diperoleh,
                    'harga_satuan_point' => $setting->harga_satuan_point,
                ],
                'transaction_amount' => $transactionAmount,
                'earned_points' => $earnedPoints,
                'discounts' => $discounts
            ]);

        } catch (\Exception $e) {
            Log::error('Error calculating preview: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Error calculating preview: ' . $e->getMessage()
            ], 500);
        }
    }
}
