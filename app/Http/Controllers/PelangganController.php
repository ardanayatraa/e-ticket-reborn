<?php
// app/Http/Controllers/PelangganController.php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

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
}
