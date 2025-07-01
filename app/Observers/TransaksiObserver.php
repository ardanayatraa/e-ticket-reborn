<?php
namespace App\Observers;

use App\Mail\SendTicket;
use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\Transaksi;
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
            'total_profit'          => $transaksi->deposit -  $transaksi->pay_to_provider + $transaksi->owe_to_me ,
        ]);
    }

    /**
     * (Optional) Jika Anda mau auto‐update detail saat Transaksi “updated”.
     */
    public function updated(Transaksi $transaksi)
    {
        if (
            $transaksi->wasChanged('transaksi_status')
            && $transaksi->transaksi_status === 'paid'
        ) {
            if (! $transaksi->ketersediaan()->exists()) {
                $p     = $transaksi->pemesanan;

                $mobil = Mobil::find($p->mobil_id);
                // 1. Create Ketersediaan
                Ketersediaan::create([
                    'pemesanan_id'         => $transaksi->pemesanan_id,
                    'mobil_id'             => $mobil->mobil_id,
                    'sopir_id'             => $mobil->sopir->sopir_id,
                    'tanggal_keberangkatan'=> $p->tanggal_keberangkatan,
                    'status_ketersediaan'  => false,
                ]);

            }

            // Mail::to($transaksi->pelanggan->email)->send(new SendTicket($transaksi));
        }

        if ($transaksi->detailTransaksi) {
            $transaksi->detailTransaksi()->update([
                'total_transaksi'       => $transaksi->total_transaksi,
                'total_owe_to_me'       => $transaksi->owe_to_me,
                'total_pay_to_provider' => $transaksi->pay_to_provider,
                'total_profit'          => $transaksi->deposit - $transaksi->pay_to_provider + $transaksi->owe_to_me ,
            ]);
        }
    }
}
