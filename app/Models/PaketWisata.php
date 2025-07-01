<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaketWisata extends Model
{
    protected $primaryKey = 'paketwisata_id';
    protected $fillable = ['judul', 'tempat', 'durasi', 'harga','foto','deskripsi'];

    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'paketwisata_id', 'paketwisata_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'peketwisata_id', 'paketwisata_id');
    }
}
