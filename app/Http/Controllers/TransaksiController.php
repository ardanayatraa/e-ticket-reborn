<?php

namespace App\Http\Controllers;

use App\Exports\TransaksiExport;
use App\Jobs\SendTicketJob;
use App\Mail\SendTicket;
use App\Models\Transaksi;
use App\Models\PaketWisata;
use App\Models\Pelanggan;
use App\Models\Pemesanan;
use Illuminate\Http\Request;
use App\Models\IncludeModel;
use App\Models\Exclude;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Excel;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['paketWisata', 'pelanggan', 'pemesanan'])->get();
        return view('transaksi.index', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pakets     = PaketWisata::all();
        $pelanggans = Pelanggan::all();
        $pesanan  = Pemesanan::all();

        return view('transaksi.create', compact('pakets', 'pelanggans', 'pesanan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'paketwisata_id'   => 'required|exists:paket_wisatas,paketwisata_id',
            'pemesan_id'       => 'required|exists:pelanggans,pelanggan_id',
            'pemesanan_id'     => 'required|exists:pemesanans,pemesanan_id',
            'jenis_transaksi'  => 'required|string|max:255',
            'deposit'          => 'required|numeric|min:0',
            'balance'          => 'required|numeric|min:0',
            'jumlah_peserta'   => 'required|integer|min:1',
            'owe_to_me'        => 'numeric|min:0',
            'pay_to_provider'  => 'numeric|min:0',
            'total_transaksi'  => 'required|numeric|min:0',
            'transaksi_status' => 'required|string|in:pending,paid,cancelled',
        ]);

        Transaksi::create($data);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaksi $transaksi)
    {
        return view('transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $pakets     = PaketWisata::all();
        $pelanggans = Pelanggan::all();
        $pesanan  = Pemesanan::all();

        return view('transaksi.edit', compact('transaksi', 'pakets', 'pelanggans', 'pesanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            'jenis_transaksi'  => 'required|string|max:255',
            'deposit'          => 'required|numeric|min:0',
            'balance'          => 'required|numeric|min:0',
            'jumlah_peserta'   => 'required|integer|min:1',
            'owe_to_me'        => 'numeric|min:0',
            'pay_to_provider'  => 'numeric|min:0',
            'total_transaksi'  => 'required|numeric|min:0',
            'transaksi_status' => 'required|string|in:pending,paid,cancelled',
        ]);

        $transaksi->update($data);

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }

    /**
     * Generate and send the e-ticket for a transaction.
     */
    public function ticket(Transaksi $transaksi)
    {
        abort(501, 'Metode ticket() belum diimplementasikan.');
    }

    public function confirmPayment(Request $request, Transaksi $transaksi)
    {
        // 1. Ambil data dari request
        $jenisPembayaran   = $request->input('jenis_pembayaran');
        $deposit           = (float) $request->input('deposit', 0);
        $additionalCharge  = (float) $request->input('additional_charge', 0);
        $payToProvider     = (float) $request->input('pay_to_provider', 0);
        $include           = $request->input('include', []); // array include
        $note              = $request->input('note'); // ambil note

        // 2. Hitung ulang total_transaksi dan owe_to_me
        $hargaPaket     = optional($transaksi->paketWisata)->harga ?? 0;
        $newTotal       = $hargaPaket + $additionalCharge;
        $oweToMe        = max($newTotal - $deposit, 0);

        // 3. Update kolom transaksi, termasuk include_data untuk menyimpan pilihan include
        $transaksi->update([
            'jenis_transaksi'   => $jenisPembayaran,
            'deposit'           => $deposit,
            'additional_charge' => $additionalCharge,
            'total_transaksi'   => $newTotal,
            'pay_to_provider'   => $payToProvider,
            'owe_to_me'         => $oweToMe,
            'transaksi_status'  => 'paid',
            'note'              => $note,
            'include_data'      => json_encode($include), // Simpan pilihan include sebagai JSON
        ]);

        // 4. Daftar field include/exclude
        $fieldList = ['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk'];

        // 5. Update atau buat data include untuk paket wisata ini
        $paketWisataId = $transaksi->paketwisata_id;

        // Cek apakah sudah ada data include untuk paket wisata ini
        $existingInclude = IncludeModel::where('paketwisata_id', $paketWisataId)->first();

        $includeData = array_merge(
            [
                'paketwisata_id'      => $paketWisataId,
                'status_ketersediaan' => true,
            ],
            collect($fieldList)
                ->mapWithKeys(fn($f) => [$f => !empty($include[$f])])
                ->toArray()
        );

        if ($existingInclude) {
            $existingInclude->update($includeData);
        } else {
            IncludeModel::create($includeData);
        }

        // 6. Update atau buat data exclude untuk paket wisata ini
        $existingExclude = Exclude::where('paketwisata_id', $paketWisataId)->first();

        $excludeData = array_merge(
            [
                'paketwisata_id'      => $paketWisataId,
                'status_ketersediaan' => true,
            ],
            collect($fieldList)
                ->mapWithKeys(fn($f) => [$f => empty($include[$f])])
                ->toArray()
        );

        if ($existingExclude) {
            $existingExclude->update($excludeData);
        } else {
            Exclude::create($excludeData);
        }

        // 7. POINTS WILL BE ADDED AUTOMATICALLY BY OBSERVER WHEN STATUS CHANGES TO 'paid'

        // 8. (Optional) Kirim tiket
        SendTicketJob::dispatch($transaksi);

        // 9. Redirect dengan pesan sukses
        return redirect()
            ->route('transaksi.index')
            ->with('success', 'Transaksi berhasil diupdate. Data akan muncul di laporan.');
    }

    /**
     * Tampilkan halaman laporan transaksi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function laporan(Request $request)
    {
        $transaksi = Transaksi::orderBy('created_at', 'desc')->get();
        return view('transaksi.laporan', compact('transaksi'));
    }

    /**
     * Download data transaksi sebagai file Excel.
     */
    public function export()
    {
        return Excel::download(new TransaksiExport, 'laporan_transaksi_'.date('Ymd_His').'.xlsx');
    }

    public function dashboard()
    {
        $now = Carbon::now();

        $paidThisMonth = \App\Models\Transaksi::where('transaksi_status', 'paid')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year);

        return view('dashboard', [
            'totalTransaksi' => $paidThisMonth->count(),
            'totalOmzet'     => $paidThisMonth->sum('deposit') - $paidThisMonth->sum('pay_to_provider') +  $paidThisMonth->sum('owe_to_me'),
            'totalPelanggan' => \App\Models\Pelanggan::count(),
            'totalPaket'     => \App\Models\PaketWisata::count(),
            'totalMobil'     => \App\Models\Mobil::count(),
            'totalPemesanan' => \App\Models\Pemesanan::count(),
        ]);
    }
}
