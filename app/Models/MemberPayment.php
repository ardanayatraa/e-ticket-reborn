<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'pelanggan_id',
        'order_id',
        'amount',
        'payment_status',
        'payment_type',
        'transaction_id',
        'midtrans_response'
    ];

    protected $casts = [
        'midtrans_response' => 'array',
        'amount' => 'decimal:2'
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }
}
