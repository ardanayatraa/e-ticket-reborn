<?php
// app/Http/Controllers/KetersediaanController.php

namespace App\Http\Controllers;

use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use Illuminate\Http\Request;

class KetersediaanController extends Controller
{
    public function index()
    {
        $data = Ketersediaan::with('pelanggan','mobil','paketWisata')->get();
        return view('ketersediaan.index', compact('data'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $mobils  = Mobil::all();
        $paketWisata = PaketWisata::all();
        return view('ketersediaan.create', compact('pelanggan','mobils','paketWisata'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id'         => 'required|exists:pelanggans,pelanggan_id',
            'paketwisata_id'       => 'required|exists:paket_wisatas,paketwisata_id',
            'mobil_id'             => 'required|exists:mobils,mobil_id',
            'jam_mulai'            => 'required',
            'tanggal_keberangkatan'=> 'required|date',
            'status_ketersediaan'  => 'required|string',
        ]);

        Ketersediaan::create($data);
        return redirect()->route('ketersediaan.index')->with('success', 'Ketersediaan created.');
    }

    public function show(Ketersediaan $ketersediaan)
    {
        return view('ketersediaan.show', compact('ketersediaan'));
    }

    public function edit(Ketersediaan $ketersediaan)
    {
        $pelanggan = Pelanggan::all();
        $mobils  = Mobil::all();
        $paketWisata = PaketWisata::all();
        return view('ketersediaan.edit', compact('ketersediaan','pelanggan','mobils','paketWisata'));
    }

    public function update(Request $request, Ketersediaan $ketersediaan)
    {
        $data = $request->validate([
            'pelanggan_id'         => 'required|exists:pelanggans,pelanggan_id',
            'paketwisata_id'       => 'required|exists:paket_wisatas,paketwisata_id',
            'mobil_id'             => 'required|exists:mobils,mobil_id',
            'jam_mulai'            => 'required',
            'tanggal_keberangkatan'=> 'required|date',
            'status_ketersediaan'  => 'required|string',
        ]);

        $ketersediaan->update($data);
        return redirect()->route('ketersediaan.index')->with('success', 'Ketersediaan updated.');
    }

    public function destroy(Ketersediaan $ketersediaan)
    {
        $ketersediaan->delete();
        return redirect()->route('ketersediaan.index')->with('success', 'Ketersediaan deleted.');
    }
}
