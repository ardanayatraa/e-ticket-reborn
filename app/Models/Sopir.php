<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sopir extends Model
{
    protected $primaryKey = 'sopir_id';
    protected $fillable = ['nama_sopir', 'nomor_ktp', 'sim', 'foto', 'umur', 'alamat'];

    public function mobils()
    {
        return $this->hasMany(Mobil::class, 'sopir_id');
    }
}

