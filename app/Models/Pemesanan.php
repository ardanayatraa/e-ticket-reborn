<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $primaryKey = 'pemesanan_id';
    protected $fillable = ['pemesan_id', 'paketwisata_id', 'mobil_id', 'jam_mulai', 'tanggal_keberangkatan'];

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
}
