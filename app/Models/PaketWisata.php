<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaketWisata extends Model
{
    use HasFactory;

    protected $table = 'paket_wisatas';
    protected $primaryKey = 'paketwisata_id';

    protected $fillable = [
        'judul',
        'tempat',
        'deskripsi',
        'durasi',
        'harga',
        'foto',
        'gallery',
        'slug'
    ];

    protected $casts = [
        'gallery' => 'array',
        'harga' => 'decimal:2'
    ];

    // Auto generate slug
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($paket) {
            if (empty($paket->slug)) {
                $paket->slug = Str::slug($paket->judul);
            }
        });

        static::updating(function ($paket) {
            if ($paket->isDirty('judul') && empty($paket->slug)) {
                $paket->slug = Str::slug($paket->judul);
            }
        });
    }

    // Relasi dengan Include dan Exclude
    public function include()
    {
        return $this->hasOne(IncludeModel::class, 'paketwisata_id', 'paketwisata_id');
    }

    public function exclude()
    {
        return $this->hasOne(Exclude::class, 'paketwisata_id', 'paketwisata_id');
    }

    // Relasi lainnya
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'paketwisata_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'paketwisata_id');
    }

    // Route model binding by slug
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // Accessor untuk gallery
    public function getGalleryUrlsAttribute()
    {
        if (!$this->gallery) {
            return [];
        }

        return collect($this->gallery)->map(function ($image) {
            return asset('storage/' . $image);
        })->toArray();
    }
}
