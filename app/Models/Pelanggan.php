<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    // Nama tabel jika tidak mengikuti konvensi plural default
    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';

    /**
     * Atribut yang boleh diisi massal.
     */
    protected $fillable = [
        'nama_pemesan',
        'alamat',
        'email',
        'nomor_whatsapp',
        'password',
    ];

    /**
     * Atribut yang disembunyikan ketika model di-serialize.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Relasi ke model Pemesanan.
     */
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'pemesan_id', 'pelanggan_id');
    }
}
