<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Jika tabel tidak bernama "admins", kamu bisa tambahkan:
    // protected $table = 'admins';

    protected $primaryKey = 'admin_id';

    /**
     * Kolom yang boleh di‐mass assignable.
     */
    protected $fillable = [
        'nama_admin',
        'email',
        'password',
        'type',
    ];

    /**
     * Casting kolom.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
