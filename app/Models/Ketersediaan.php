<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketersediaan extends Model
{
    use HasFactory;

    protected $primaryKey = 'terpesan_id';
    protected $fillable = [
        'pelanggan_id', 
        'paketwisata_id', 
        'mobil_id', 
        'jam_mulai', 
        'tanggal_keberangkatan', 
        'status_ketersediaan'
    ];

    protected $casts = [
        'tanggal_keberangkatan' => 'date',
        'jam_mulai' => 'datetime:H:i',
    ];

    // Relationships
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id', 'pelanggan_id');
    }

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paketwisata_id', 'paketwisata_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }

    public function transaksi()
    {
        return $this->hasOne(Transaksi::class, 'terpesan_id', 'terpesan_id');
    }



    // Scopes for filtering
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

    // Accessors
    public function getStatusPembayaranAttribute()
    {
        if ($this->transaksi) {
            return $this->transaksi->transaksi_status;
        }
        return 'unknown';
    }

    public function getTotalHargaAttribute()
    {
        if ($this->transaksi) {
            return $this->transaksi->total_transaksi;
        }
        return 0;
    }
}
