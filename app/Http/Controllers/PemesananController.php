<?php
// app/Http/Controllers/PemesananController.php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    public function index()
    {
        $pesanan = Pemesanan::with('pelanggan','paketWisata')->get();
        return view('pemesanan.index', compact('pesanan'));
    }

    public function create()
    {
        $pelanggan = Pelanggan::all();
        $pakets    = PaketWisata::all();
        return view('pemesanan.create', compact('pelanggan','pakets'));
    }

public function store(Request $request)
{
    $request->validate([
        'paket_id'         => 'required|integer|exists:paket_wisatas,paketwisata_id',
        'tanggal'          => 'required|date_format:Y-m-d',
        'jam_mulai'        => 'required|string|max:20',
        'nama_pemesan'     => 'required|string|max:255',
        'email'            => 'required|email|max:255',
        'alamat'           => 'required|string|max:500',
        'nomor_whatsapp'   => 'required|string|max:20',
        'mobil_ids'        => 'required|array|min:1',
        'mobil_ids.*'      => 'required|integer|exists:mobils,mobil_id',
        'jumlah_peserta'   => 'required|array|min:1',
        'jumlah_peserta.*' => 'required|integer|min:1',
    ]);

    if (count($request->mobil_ids) !== count($request->jumlah_peserta)) {
        return back()->withErrors(['error' => 'Data mobil dan jumlah peserta tidak sesuai']);
    }

    DB::beginTransaction();

    // 1) Cek atau buat pelanggan
    $pelanggan = Pelanggan::where('email', $request->email)->first();
    if (!$pelanggan) {
        $pelanggan = Pelanggan::create([
            'email'           => $request->email,
            'nama_pemesan'    => $request->nama_pemesan,
            'alamat'          => $request->alamat,
            'nomor_whatsapp'  => $request->nomor_whatsapp,
        ]);
    }

    $paketWisata    = PaketWisata::findOrFail($request->paket_id);
    $totalPemesanan = count($request->mobil_ids);
    $pemesananIds   = [];
    $totalHarga     = 0;

    // 2) Validasi kapasitas dulu semua sebelum proses insert
    foreach ($request->mobil_ids as $index => $mobilId) {
        $mobil = Mobil::findOrFail($mobilId);
        if ($request->jumlah_peserta[$index] > $mobil->jumlah_tempat_duduk) {
            DB::rollBack();
            return back()->withErrors([
                'error' => "Jumlah peserta untuk mobil {$mobil->nama_kendaraan} melebihi kapasitas",
            ]);
        }
    }

    // 3) Loop simpan data
    foreach ($request->mobil_ids as $index => $mobilId) {
        $jumlahPeserta = $request->jumlah_peserta[$index];

        $pemesanan = Pemesanan::create([
            'pemesan_id'            => $pelanggan->pelanggan_id,
            'paketwisata_id'        => $request->paket_id,
            'mobil_id'              => $mobilId,
            'tanggal_keberangkatan' => $request->tanggal,
            'jam_mulai'             => $request->jam_mulai,
        ]);

        $pemesananIds[] = $pemesanan->pemesanan_id;

        $hargaPemesanan = $paketWisata->harga * $jumlahPeserta;
        $totalHarga    += $hargaPemesanan;

        Transaksi::create([
            'paketwisata_id'   => $request->paket_id,
            'pemesan_id'       => $pelanggan->pelanggan_id,
            'pemesanan_id'     => $pemesanan->pemesanan_id,
            'deposit'          => 0,
            'balance'          => 0,
            'jumlah_peserta'   => $jumlahPeserta,
            'owe_to_me'        => 0,
            'pay_to_provider'  => 0,
            'total_transaksi'  => $hargaPemesanan,
            'transaksi_status' => 'pending',
        ]);
    }

    DB::commit();

    return redirect()
        ->route('paket-wisata.landing')
        ->with('success', "Berhasil membuat {$totalPemesanan} pemesanan dengan total Rp " . number_format($totalHarga, 0, ',', '.'))
        ->with('booking_info', [
            'total_pemesanan' => $totalPemesanan,
            'total_harga'     => $totalHarga,
            'pemesanan_ids'   => $pemesananIds,
        ]);
}


    public function show(Pemesanan $pemesanan)
    {
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function edit(Pemesanan $pemesanan)
    {
        $pelanggan = Pelanggan::all();
        $pakets    = PaketWisata::all();
        $mobils    = Mobil::all();
        return view('pemesanan.edit', compact('pemesanan','pelanggan','pakets','mobils'));
    }

    public function update(Request $request, Pemesanan $pemesanan)
    {
        $data = $request->validate([
            'pemesan_id'            => 'required',
            'paketwisata_id'        => 'required',
            'mobil_id'              => 'required',
            'jam_mulai'             => 'required',
            'tanggal_keberangkatan' => 'required|date',
        ]);

        $pemesanan->update($data);
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan updated.');
    }

    public function destroy(Pemesanan $pemesanan)
    {
        $pemesanan->delete();
        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan deleted.');
    }
}
