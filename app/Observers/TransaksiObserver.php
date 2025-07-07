<?php

namespace App\Observers;

use App\Mail\SendTicket;
use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\Transaksi;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransaksiObserver
{
    /**
     * Handle the Transaksi “created” event.
     */
    public function created(Transaksi $transaksi)
    {
        $transaksi->detailTransaksi()->create([
            'total_transaksi'       => $transaksi->total_transaksi,
            'total_owe_to_me'       => $transaksi->owe_to_me,
            'total_pay_to_provider' => $transaksi->pay_to_provider,
            'total_profit'          => $transaksi->deposit -  $transaksi->pay_to_provider + $transaksi->owe_to_me,
        ]);
    }

    /**
     * Handle the Transaksi “updated” event.
     */
    public function updated(Transaksi $transaksi)
    {
        if (
            $transaksi->wasChanged('transaksi_status')
            && $transaksi->transaksi_status === 'paid'
        ) {
            Log::info('Transaksi updated to paid', [
                'transaksi_id' => $transaksi->transaksi_id,
                'status' => $transaksi->transaksi_status
            ]);

            // Jika belum ada ketersediaan, buat
            if (! $transaksi->ketersediaan()->exists()) {
                $p     = $transaksi->pemesanan;
                $mobil = Mobil::find($p->mobil_id);

                Ketersediaan::create([
                    'pemesanan_id'          => $transaksi->pemesanan_id,
                    'mobil_id'              => $mobil->mobil_id,
                    'sopir_id'              => $mobil->sopir->sopir_id,
                    'tanggal_keberangkatan' => $p->tanggal_keberangkatan,
                    'status_ketersediaan'   => false,
                ]);
            }

            // Update poin pelanggan saat transaksi dibayar
            if ($transaksi->pelanggan) {
                $pelanggan = $transaksi->pelanggan;

                $poinTambahan = floor($transaksi->total_transaksi / 500000) * 5;

                $pelanggan->update([
                    'points' => $pelanggan->point + $poinTambahan,
                ]);

                Log::info('Poin pelanggan ditambahkan', [
                    'pelanggan_id' => $pelanggan->pelanggan_id,
                    'poin_ditambah' => $poinTambahan,
                    'poin_total_baru' => $pelanggan->point + $poinTambahan,
                ]);
            }

            // Kirim tiket via email (jika aktif)
            // Mail::to($transaksi->pelanggan->email)->send(new SendTicket($transaksi));
        }

        // Update detailTransaksi jika ada
        if ($transaksi->detailTransaksi) {
            $transaksi->detailTransaksi()->update([
                'total_transaksi'       => $transaksi->total_transaksi,
                'total_owe_to_me'       => $transaksi->owe_to_me,
                'total_pay_to_provider' => $transaksi->pay_to_provider,
                'total_profit'          => $transaksi->deposit - $transaksi->pay_to_provider + $transaksi->owe_to_me,
            ]);
        }
    }
}
