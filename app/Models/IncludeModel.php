<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncludeModel extends Model
{

    protected $table = 'includes';
    protected $primaryKey = 'include_id';
    protected $fillable = ['pemesanan_id', 'bensin', 'parkir', 'sopir', 'makan_siang', 'makan_malam', 'tiket_masuk', 'status_ketersediaan'];

    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'pemesanan_id');
    }
}
