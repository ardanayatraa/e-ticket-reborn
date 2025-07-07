<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PelangganController extends Controller
{
    public function index()
    {
        $pelanggan = Pelanggan::all();
        return view('pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('pelanggan.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_pemesan'   => 'required|string|max:255',
            'alamat'         => 'required|string',
            'email'          => 'required|email|unique:pelanggans,email',
            'nomor_whatsapp' => 'required|string',
        ]);
        Pelanggan::create($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan created.');
    }

    public function show(Pelanggan $pelanggan)
    {
        return view('pelanggan.show', compact('pelanggan'));
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('pelanggan.edit', compact('pelanggan'));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            'nama_pemesan'   => 'required|string|max:255',
            'alamat'         => 'required|string',
            'email'          => 'required|email|unique:pelanggans,email,'.$pelanggan->pelanggan_id.',pelanggan_id',
            'nomor_whatsapp' => 'required|string',
        ]);
        $pelanggan->update($data);

        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan updated.');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan deleted.');
    }

    // Method untuk update profile pelanggan (diperbaiki)
    public function updateProfile(Request $request)
    {
        try {
            $pelanggan = Auth::guard('pelanggan')->user();

            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            $rules = [
                'nama_pemesan'   => 'required|string|max:255',
                'alamat'         => 'required|string',
                'email'          => 'required|email|unique:pelanggans,email,'.$pelanggan->pelanggan_id.',pelanggan_id',
                'nomor_whatsapp' => 'required|string',
            ];

            // Jika password diisi, tambahkan validasi
            if ($request->filled('password')) {
                $rules['password'] = 'required|min:6|confirmed';
            }

            $data = $request->validate($rules);

            // Hash password jika diisi
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $pelanggan->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Profile berhasil diperbarui'
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    // Method untuk tukar poin (diperbaiki)
    public function redeemPoints(Request $request)
    {
        try {
            $pelanggan = Auth::guard('pelanggan')->user();

            if (!$pelanggan) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak ditemukan'
                ], 401);
            }

            if (!$pelanggan->is_member) {
                return response()->json([
                    'success' => false,
                    'message' => 'Hanya member yang dapat menukar poin'
                ], 403);
            }

            $request->validate([
                'points_to_redeem' => 'required|integer|min:10'
            ]);

            $pointsToRedeem = $request->points_to_redeem;

            // Validasi poin harus kelipatan 10
            if ($pointsToRedeem % 10 !== 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Poin harus dalam kelipatan 10'
                ], 400);
            }

            // Cek apakah poin cukup
            if ($pelanggan->points < $pointsToRedeem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Poin tidak mencukupi'
                ], 400);
            }

            // Hitung nilai tukar: 10 poin = Rp 10.000
            $cashValue = ($pointsToRedeem / 10) * 10000;

            // Kurangi poin
            $pelanggan->decrement('points', $pointsToRedeem);

            // Log transaksi penukaran poin (opsional, bisa dibuat tabel terpisah)
            \Log::info('Points redeemed', [
                'pelanggan_id' => $pelanggan->pelanggan_id,
                'points_redeemed' => $pointsToRedeem,
                'cash_value' => $cashValue,
                'remaining_points' => $pelanggan->points
            ]);

            return response()->json([
                'success' => true,
                'message' => "Berhasil menukar {$pointsToRedeem} poin menjadi Rp " . number_format($cashValue, 0, ',', '.'),
                'remaining_points' => $pelanggan->points,
                'cash_value' => $cashValue
            ]);

        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}
