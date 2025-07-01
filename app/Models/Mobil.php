<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $primaryKey = 'mobil_id';
    protected $fillable = ['sopir_id', 'nama_kendaraan', 'nomor_kendaraan', 'jumlah_tempat_duduk', 'status_ketersediaan','foto'];

    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id');
    }

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'mobil_id', 'mobil_id');
    }

    public function ketersediaans()
    {
        return $this->hasMany(Ketersediaan::class, 'mobil_id', 'mobil_id');
    }
}

