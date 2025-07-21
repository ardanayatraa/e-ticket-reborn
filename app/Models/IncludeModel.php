<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncludeModel extends Model
{
    use HasFactory;

    protected $table = 'includes';
    protected $primaryKey = 'include_id';
    protected $fillable = [
        'paketwisata_id',
        'bensin',
        'parkir',
        'sopir',
        'makan_siang',
        'makan_malam',
        'tiket_masuk',
        'status_ketersediaan'
    ];

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paketwisata_id', 'paketwisata_id');
    }


}
