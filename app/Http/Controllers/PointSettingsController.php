<?php

namespace App\Http\Controllers;

use App\Models\PointSetting;
use Illuminate\Http\Request;

class PointSettingsController extends Controller
{
    public function index()
    {
        $settings = PointSetting::all();
        return view('point-settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'points_per_transaction' => 'required|integer|min:10000',
            'points_earned_per_transaction' => 'required|integer|min:1',
            'points_for_discount' => 'required|integer|min:1',
            'discount_per_points' => 'required|integer|min:1000',
        ]);

        try {
            // Update each setting
            PointSetting::setValue('points_per_transaction', $request->points_per_transaction);
            PointSetting::setValue('points_earned_per_transaction', $request->points_earned_per_transaction);
            PointSetting::setValue('points_for_discount', $request->points_for_discount);
            PointSetting::setValue('discount_per_points', $request->discount_per_points);

            return redirect()->route('point-settings.index')
                ->with('success', 'Pengaturan poin berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('point-settings.index')
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }
} 