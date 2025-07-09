<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use App\Models\Pemesanan;
use App\Models\Pelanggan;
use App\Models\PaketWisata;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
class PemesananController extends Controller
{
    public function index()
    {
        $pesanan = Pemesanan::with('pelanggan','paketWisata')->get();
        return view('pemesanan.index', compact('pesanan'));
    }

    public function create(Request $request)
    {
        // Harus login sebagai pelanggan
        if (!Auth::guard('pelanggan')->check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu untuk melakukan pemesanan.'], 401);
        }

        $paketId = $request->get('paket');
        $paket = null;

        if ($paketId) {
            $paket = PaketWisata::find($paketId);
        }

        $mobil = Mobil::all();

        return view('pemesanan.create', compact('paket', 'mobil'));
    }

    public function store(Request $request)
    {
        // Harus login sebagai pelanggan
        if (!Auth::guard('pelanggan')->check()) {
            return response()->json(['error' => 'Silakan login terlebih dahulu untuk melakukan pemesanan.'], 401);
        }

        try {
            $validated = $request->validate([
                'paket_id'         => 'required|integer|exists:paket_wisatas,paketwisata_id',
                'tanggal'          => 'required|date_format:Y-m-d|after_or_equal:today',
                'jam_mulai'        => 'required|string|max:20',
                'mobil_ids'        => 'required|array|min:1',
                'mobil_ids.*'      => 'required|integer|exists:mobils,mobil_id',
                'jumlah_peserta'   => 'required|array|min:1',
                'jumlah_peserta.*' => 'required|integer|min:1',
                'points_used'      => 'nullable|integer|min:0', // OPSIONAL - bisa 0 atau tidak diisi
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Data tidak valid',
                'details' => $e->errors()
            ], 422);
        }

        if (count($request->mobil_ids) !== count($request->jumlah_peserta)) {
            return response()->json(['error' => 'Data mobil dan jumlah peserta tidak sesuai'], 400);
        }

        DB::beginTransaction();

        try {
            $pelanggan = Auth::guard('pelanggan')->user();
            $paketWisata = PaketWisata::findOrFail($request->paket_id);
            $totalPemesanan = count($request->mobil_ids);
            $pemesananIds = [];
            $totalHarga = 0;
            $pointsUsed = (int) ($request->points_used ?? 0); // Default 0 jika tidak diisi
            $totalDiscount = 0;

            // HANYA validasi poin jika pelanggan MEMILIH untuk menggunakan poin
            if ($pointsUsed > 0) {
                if (!$pelanggan->is_member) {
                    throw new \Exception("Hanya member yang dapat menggunakan poin");
                }

                if ($pointsUsed > $pelanggan->points) {
                    throw new \Exception("Poin tidak mencukupi. Anda memiliki {$pelanggan->points} poin");
                }

                if ($pointsUsed % 10 !== 0) {
                    throw new \Exception("Poin harus dalam kelipatan 10");
                }

                // Hitung diskon: 10 poin = Rp 10.000
                $totalDiscount = ($pointsUsed / 10) * 10000;
            }

            // Validasi kapasitas dan durasi
            foreach ($request->mobil_ids as $index => $mobilId) {
                $mobil = Mobil::findOrFail($mobilId);
                if ($request->jumlah_peserta[$index] > $mobil->jumlah_tempat_duduk) {
                    throw new \Exception("Jumlah peserta untuk mobil {$mobil->nama_kendaraan} melebihi kapasitas ({$mobil->jumlah_tempat_duduk} kursi)");
                }
            }

            // Validasi durasi maksimal 9 jam
            if ($paketWisata->max_duration > 9) {
                throw new \Exception("Durasi paket tidak boleh melebihi 9 jam per hari");
            }

            // Hitung total harga sebelum diskon
            foreach ($request->jumlah_peserta as $jumlahPeserta) {
                $totalHarga += $paketWisata->harga;
            }

            // Terapkan diskon HANYA jika pelanggan memilih menggunakan poin
            $finalTotal = $totalHarga - $totalDiscount;

            // Pastikan total tidak negatif
            if ($finalTotal < 0) {
                $finalTotal = 0;
                // Adjust discount jika melebihi total harga
                $totalDiscount = $totalHarga;
                $pointsUsed = ($totalDiscount / 10000) * 10; // Recalculate points used
            }

            // Kurangi poin HANYA jika pelanggan memilih menggunakan poin
           if ($pointsUsed > 0) {
    $pelanggan->points = max(0, $pelanggan->points - $pointsUsed);
    $pelanggan->save();
}


            // Loop simpan data pemesanan
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

                // Hitung harga per pemesanan (proporsional dengan diskon)
                $hargaPemesanan = $paketWisata->harga;
                $discountPerBooking = $totalPemesanan > 1 ? ($totalDiscount / $totalPemesanan) : $totalDiscount;
                $finalHargaPemesanan = max(0, $hargaPemesanan - $discountPerBooking);

                // Buat transaksi dengan order_id untuk Midtrans
                $orderId = 'BOOKING-' . $pemesanan->pemesanan_id . '-' . time();

                // Buat note hanya jika menggunakan poin
                $note = null;
                if ($pointsUsed > 0) {
                    $note = "Menggunakan {$pointsUsed} poin (diskon Rp " . number_format($totalDiscount, 0, ',', '.') . ")";
                }

                $transaksi = Transaksi::create([
                    'paketwisata_id'   => $request->paket_id,
                    'pemesan_id'       => $pelanggan->pelanggan_id,
                    'pemesanan_id'     => $pemesanan->pemesanan_id,
                    'order_id'         => $orderId,
                    'deposit'          => 0, // Akan diisi setelah pembayaran via Midtrans
                    'balance'          => 0,
                    'jumlah_peserta'   => $jumlahPeserta,
                    'owe_to_me'        => 0,
                    'pay_to_provider'  => 0,
                    'total_transaksi'  => $finalHargaPemesanan, // Harga setelah diskon (jika ada)
                    'transaksi_status' => 'pending',
                    'additional_charge'=> 0,
                    'note'             => $note,
                ]);
            }

            DB::commit();

            // Setup Midtrans untuk pembayaran
            $firstTransaksi = Transaksi::where('pemesanan_id', $pemesananIds[0])->first();

            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            // Item details untuk Midtrans
            $itemDetails = [];

            // Item paket wisata (harga asli)
            $itemDetails[] = [
                'id' => 'PAKET-' . $paketWisata->paketwisata_id,
                'price' => $totalHarga,
                'quantity' => 1,
                'name' => $paketWisata->judul . ' (' . $totalPemesanan . ' mobil)'
            ];

            // Item diskon HANYA jika pelanggan menggunakan poin
            if ($totalDiscount > 0) {
                $itemDetails[] = [
                    'id' => 'DISCOUNT-POINTS',
                    'price' => -$totalDiscount, // Negatif untuk diskon
                    'quantity' => 1,
                    'name' => "Diskon Member ({$pointsUsed} poin)"
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $firstTransaksi->order_id,
                    'gross_amount' => $finalTotal, // Total setelah diskon (jika ada)
                ],
                'customer_details' => [
                    'first_name' => $pelanggan->nama_pemesan,
                    'email' => $pelanggan->email,
                    'phone' => $pelanggan->nomor_whatsapp,
                ],
                'item_details' => $itemDetails
            ];

            try {
                $snapToken = \Midtrans\Snap::getSnapToken($params);
            } catch (\Exception $e) {
                // Rollback jika Midtrans gagal
                DB::rollBack();

                // Kembalikan poin jika sudah dikurangi
                if ($pointsUsed > 0) {
                    $pelanggan->increment('points', $pointsUsed);
                }

                return response()->json(['error' => 'Gagal membuat pembayaran: ' . $e->getMessage()], 500);
            }

            $responseMessage = "Berhasil membuat {$totalPemesanan} pemesanan. Silakan lakukan pembayaran.";
            if ($pointsUsed > 0) {
                $responseMessage .= " Anda menghemat Rp " . number_format($totalDiscount, 0, ',', '.') . " dengan {$pointsUsed} poin!";
            }

            return response()->json([
                'success' => true,
                'message' => $responseMessage,
                'snap_token' => $snapToken,
                'booking_info' => [
                    'total_pemesanan' => $totalPemesanan,
                    'total_harga' => $totalHarga,
                    'total_discount' => $totalDiscount,
                    'final_total' => $finalTotal,
                    'points_used' => $pointsUsed,
                    'pemesanan_ids' => $pemesananIds,
                ]
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            // Kembalikan poin jika sudah dikurangi
            if (isset($pointsUsed) && $pointsUsed > 0) {
                $pelanggan->increment('points', $pointsUsed);
            }

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Pemesanan $pemesanan)
    {
        return view('pemesanan.show', compact('pemesanan'));
    }

    public function edit(Pemesanan $pemesanan)
    {
        $pelanggan = Pelanggan::all();
        $pakets = PaketWisata::all();
        $mobils = Mobil::all();
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


    public function download($transaksiId)
{
    $transaksi = Transaksi::with('pemesanan', 'pelanggan')->findOrFail($transaksiId);

    $pdf = Pdf::loadView('pdf.ticket', compact('transaksi'));

    return $pdf->stream('e-ticket-' . $transaksi->id . '.pdf');
}
}
