<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exclude extends Model
{
    use HasFactory;

    protected $table = 'excludes';
    protected $primaryKey = 'exclude_id';
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

    protected $casts = [
        'bensin' => 'boolean',
        'parkir' => 'boolean',
        'sopir' => 'boolean',
        'makan_siang' => 'boolean',
        'makan_malam' => 'boolean',
        'tiket_masuk' => 'boolean',
        'status_ketersediaan' => 'boolean',
    ];

    public function paketWisata()
    {
        return $this->belongsTo(PaketWisata::class, 'paketwisata_id', 'paketwisata_id');
    }


}
