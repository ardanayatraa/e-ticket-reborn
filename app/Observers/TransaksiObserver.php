<?php

namespace App\Observers;

use App\Mail\SendTicket;
use App\Models\Ketersediaan;
use App\Models\Mobil;
use App\Models\Transaksi;
use App\Models\PointSetting;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransaksiObserver
{
    /**
     * Handle the Transaksi "created" event.
     */
    public function created(Transaksi $transaksi)
    {
        // Tidak perlu update field detail transaksi lagi karena sudah dihitung otomatis via accessor
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

            // Update status ketersediaan jika sudah ada
            if ($transaksi->ketersediaan()->exists()) {
                $transaksi->ketersediaan->update([
                    'status_ketersediaan' => 'confirmed',
                ]);
            }

            // Update poin pelanggan saat transaksi dibayar
            if ($transaksi->pelanggan && $transaksi->pelanggan->is_member) {
                $pelanggan = $transaksi->pelanggan;

                // Hitung poin berdasarkan harga ASLI (sebelum diskon poin)
                $hargaAsli = $transaksi->total_transaksi;
                
                // Jika ada diskon poin, tambahkan kembali ke harga asli
                if ($transaksi->note && strpos($transaksi->note, 'Menggunakan') !== false) {
                    preg_match('/diskon Rp ([0-9,]+)/', $transaksi->note, $matches);
                    if (isset($matches[1])) {
                        $diskon = (int) str_replace(',', '', $matches[1]);
                        $hargaAsli += $diskon;
                    }
                }

                // Ambil pengaturan poin dari database
                $poinTambahan = PointSetting::calculateEarnedPoints($hargaAsli);

                if ($poinTambahan > 0) {
                    $pelanggan->update([
                        'points' => $pelanggan->points + $poinTambahan,
                    ]);

                    Log::info('Poin pelanggan ditambahkan', [
                        'pelanggan_id' => $pelanggan->pelanggan_id,
                        'nama_pelanggan' => $pelanggan->nama_pemesan,
                        'transaksi_id' => $transaksi->transaksi_id,
                        'total_transaksi' => $transaksi->total_transaksi,
                        'harga_asli' => $hargaAsli,
                        'poin_ditambah' => $poinTambahan,
                        'poin_total_baru' => $pelanggan->points + $poinTambahan,
                    ]);

                    // Flash message untuk notifikasi (jika dalam context web request)
                    if (request()->hasSession()) {
                        session()->flash('points_added', "Selamat! Anda mendapat {$poinTambahan} poin dari transaksi ini.");
                    }
                }
            }

            // Kirim tiket via email (jika aktif)
            // Mail::to($transaksi->pelanggan->email)->send(new SendTicket($transaksi));
        }

        // Broadcast event untuk refresh laporan real-time
        if (request()->hasSession()) {
            session()->flash('transaksi_updated', true);
        }
    }
}
