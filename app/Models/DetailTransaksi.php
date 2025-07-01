<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $primaryKey = 'detail_transaksi_id';
    protected $fillable = ['transaksi_id', 'total_transaksi', 'total_owe_to_me', 'total_pay_to_provider', 'total_profit'];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id', 'transaksi_id');
    }
}
