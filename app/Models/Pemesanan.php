<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'pemesanan_id';
    protected $fillable = ['pemesan_id', 'paketwisata_id', 'mobil_id', 'jam_mulai', 'tanggal_keberangkatan'];

    protected $casts = [
        'tanggal_keberangkatan' => 'date',
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pemesan_id', 'pelanggan_id');
    }

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paketwisata_id', 'paketwisata_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }

    public function ketersediaan()
    {
        return $this->hasOne(Ketersediaan::class, 'pemesanan_id', 'pemesanan_id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'pemesanan_id', 'pemesanan_id');
    }

    // Scope untuk filter berdasarkan status
    public function scopePaid($query)
    {
        return $query->whereHas('transaksi', function($q) {
            $q->where('transaksi_status', 'paid');
        });
    }

    public function scopePending($query)
    {
        return $query->whereHas('transaksi', function($q) {
            $q->where('transaksi_status', 'pending');
        });
    }

    // Accessor untuk status pembayaran
    public function getStatusPembayaranAttribute()
    {
        if ($this->transaksi) {
            return $this->transaksi->transaksi_status;
        }
        return 'unknown';
    }

    // Accessor untuk total harga
    public function getTotalHargaAttribute()
    {
        if ($this->transaksi) {
            return $this->transaksi->total_transaksi;
        }
        return 0;
    }
}
