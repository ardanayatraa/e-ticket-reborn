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
            'paketwisata_id'   => 'required|exists:paketwisatas,paketwisata_id',
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

    // 3. Update kolom transaksi, termasuk total_transaksi, additional_charge, dan note
    $transaksi->update([
        'jenis_transaksi'   => $jenisPembayaran,
        'deposit'           => $deposit,
        'additional_charge' => $additionalCharge,
        'total_transaksi'   => $newTotal,      // perbarui total_transaksi
        'pay_to_provider'   => $payToProvider,
        'owe_to_me'         => $oweToMe,
        'transaksi_status'  => 'paid',
        'note'              => $note,          // update note
    ]);

    // 4. Daftar field include/exclude
    $fieldList = ['bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk'];

    // 5. Simpan tabel include
    IncludeModel::create(
        array_merge(
            [
                'pemesanan_id'        => $transaksi->pemesanan_id,
                'status_ketersediaan' => true,
            ],
            collect($fieldList)
                ->mapWithKeys(fn($f) => [$f => !empty($include[$f])])
                ->toArray()
        )
    );

    // 6. Simpan tabel exclude
    Exclude::create(
        array_merge(
            [
                'pemesanan_id'        => $transaksi->pemesanan_id,
                'status_ketersediaan' => true,
            ],
            collect($fieldList)
                ->mapWithKeys(fn($f) => [$f => empty($include[$f])])
                ->toArray()
        )
    );

    // 7. (Optional) Kirim tiket
    SendTicketJob::dispatch($transaksi);

    // 8. Redirect dengan pesan sukses
    return redirect()
        ->route('transaksi.index')
        ->with('success', 'Pembayaran berhasil dikonfirmasi.');
}



     /**
     * Tampilkan halaman laporan transaksi.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
     // method laporan yang sudah ada...
     public function laporan(Request $request)
     {
         $transaksi = Transaksi::
                              orderBy('created_at', 'desc')
                                ->get();

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
