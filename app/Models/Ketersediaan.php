<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ketersediaan extends Model
{
    protected $primaryKey = 'terpesan_id';
    protected $fillable = ['pemesanan_id', 'mobil_id', 'sopir_id', 'tanggal_keberangkatan', 'status_ketersediaan'];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }

    public function mobil()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id', 'mobil_id');
    }

    public function sopir()
    {
        return $this->belongsTo(Sopir::class, 'sopir_id', 'sopir_id');
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'pemesanan_id', 'pemesanan_id');
    }
    public function include()
    {
        return $this->belongsTo(IncludeModel::class, 'pemesanan_id', 'pemesanan_id');
    }
    public function exclude()
    {
        return $this->belongsTo(Exclude::class, 'pemesanan_id', 'pemesanan_id');
    }



}
