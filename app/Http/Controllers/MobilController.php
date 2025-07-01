<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Sopir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::with('sopir')->get();
        return view('mobil.index', compact('mobils'));
    }

    public function create()
    {
        $sopirs = Sopir::all();
        return view('mobil.create', compact('sopirs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sopir_id'            => 'required|exists:sopirs,sopir_id',
            'nama_kendaraan'      => 'required|string|max:255',
            'nomor_kendaraan'     => 'required|string|max:20',
            'jumlah_tempat_duduk' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string|max:200',
            'foto'                => 'nullable|image|max:2048', // max 2MB
        ]);

        if ($request->hasFile('foto')) {
            // simpan di storage/app/public/mobil
            $data['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        Mobil::create($data);

        return redirect()
            ->route('mobil.index')
            ->with('success', 'Mobil berhasil ditambahkan.');
    }

    public function show(Mobil $mobil)
    {
        return view('mobil.show', compact('mobil'));
    }

    public function edit(Mobil $mobil)
    {
        $sopirs = Sopir::all();
        return view('mobil.edit', compact('mobil', 'sopirs'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $data = $request->validate([
            'sopir_id'            => 'required|exists:sopirs,sopir_id',
            'nama_kendaraan'      => 'required|string|max:255',
            'nomor_kendaraan'     => 'required|string|max:20',
            'jumlah_tempat_duduk' => 'required|integer|min:1',
            'status_ketersediaan' => 'required|string|max:200',
            'foto'                => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // hapus file lama jika ada
            if ($mobil->foto && Storage::disk('public')->exists($mobil->foto)) {
                Storage::disk('public')->delete($mobil->foto);
            }
            // simpan file baru
            $data['foto'] = $request->file('foto')->store('mobil', 'public');
        }

        $mobil->update($data);

        return redirect()
            ->route('mobil.index')
            ->with('success', 'Data mobil berhasil diupdate.');
    }

    public function destroy(Mobil $mobil)
    {
        // hapus file foto jika ada
        if ($mobil->foto && Storage::disk('public')->exists($mobil->foto)) {
            Storage::disk('public')->delete($mobil->foto);
        }

        $mobil->delete();

        return redirect()
            ->route('mobil.index')
            ->with('success', 'Mobil berhasil dihapus.');
    }
}
