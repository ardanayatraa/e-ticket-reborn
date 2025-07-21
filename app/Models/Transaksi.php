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
        'pelanggan_id',
        'terpesan_id',
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
     * Relasi ke Pelanggan
     */
    public function pelanggan()
    {
        return $this->belongsTo(
            Pelanggan::class,
            'pelanggan_id',
            'pelanggan_id'
        );
    }

    /**
     * Relasi ke Ketersediaan (sebelumnya Pemesanan)
     */
    public function ketersediaan()
    {
        return $this->belongsTo(
            Ketersediaan::class,
            'terpesan_id',
            'terpesan_id'
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
