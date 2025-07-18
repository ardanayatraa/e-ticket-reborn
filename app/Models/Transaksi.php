<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';
    protected $primaryKey = 'transaksi_id';

    protected $fillable = [
        'paketwisata_id',
        'pemesan_id',
        'pemesanan_id',
        'jenis_transaksi',
        'deposit',
        'balance',
        'jumlah_peserta',
        'owe_to_me',
        'owe_to_me_status',
        'pay_to_provider',
        'pay_to_provider_status',
        'additional_charge',
        'note',
        'total_transaksi',
        'transaksi_status',
        'order_id',
    ];

    /**
     * Agar status ter-handle sebagai string (enum)
     */
    protected $casts = [
        'owe_to_me'               => 'decimal:2',
        'owe_to_me_status'        => 'string',
        'pay_to_provider'         => 'decimal:2',
        'pay_to_provider_status'  => 'string',
        'additional_charge'       => 'decimal:2',
        'total_transaksi'         => 'decimal:2',
    ];

    /**
     * Relasi ke PaketWisata
     */
    public function paketWisata()
    {
        return $this->belongsTo(
            PaketWisata::class,
            'paketwisata_id',
            'paketwisata_id'
        );
    }

    /**
     * Relasi ke Pelanggan (pemesan)
     */
    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'pemesan_id',
            'pelanggan_id'
        );
    }

    /**
     * Relasi ke Pemesanan
     */
    public function pemesanan()
    {
        return $this->belongsTo(
            Pemesanan::class,
            'pemesanan_id',
            'pemesanan_id'
        );
    }

    /**
     * Ketersediaan yang dibuat saat status 'paid'
     */
    public function ketersediaan()
    {
        return $this->hasOne(
            \App\Models\Ketersediaan::class,
            'pemesanan_id',   // FK di tabel ketersediaans
            'pemesanan_id'    // PK di tabel transaksis
        );
    }

    public function includeModel()
    {
        return $this->hasOne(
            \App\Models\IncludeModel::class,
            'pemesanan_id',  // foreign key di includes
            'pemesanan_id'   // local key di transaksis
        );
    }

    public function exclude()
    {
        return $this->hasOne(
            \App\Models\Exclude::class,
            'pemesanan_id',  // foreign key di excludes
            'pemesanan_id'   // local key di transaksis
        );
    }

    /**
     * Accessor untuk total_owe_to_me (dihitung dari owe_to_me)
     */
    public function getTotalOweToMeAttribute()
    {
        return $this->owe_to_me;
    }

    /**
     * Accessor untuk total_pay_to_provider (dihitung dari pay_to_provider)
     */
    public function getTotalPayToProviderAttribute()
    {
        return $this->pay_to_provider;
    }

    /**
     * Accessor untuk total_profit (dihitung dari deposit - pay_to_provider + owe_to_me)
     */
    public function getTotalProfitAttribute()
    {
        return $this->deposit - $this->pay_to_provider + $this->owe_to_me;
    }
}
