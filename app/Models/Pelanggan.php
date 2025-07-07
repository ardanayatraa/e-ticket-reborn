<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Pelanggan extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'pelanggans';
    protected $primaryKey = 'pelanggan_id';

    protected $fillable = [
        'nama_pemesan',
        'alamat',
        'email',
        'nomor_whatsapp',
        'is_member',
        'points',
        'member_since',
        'password',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'member_since' => 'datetime',
        'is_member' => 'boolean',
    ];

    // Relasi
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'pemesan_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pemesan_id');
    }

    public function memberPayments()
    {
        return $this->hasMany(MemberPayment::class, 'pelanggan_id');
    }

    // Methods untuk member
    public function becomeMember()
    {
        try {
            $updated = $this->update([
                'is_member' => true,
                'member_since' => now()
            ]);

            if ($updated) {
                Log::info('Successfully upgraded pelanggan to member', [
                    'pelanggan_id' => $this->pelanggan_id,
                    'nama' => $this->nama_pemesan,
                    'email' => $this->email
                ]);

                // Refresh model to get updated data
                $this->refresh();

                return true;
            } else {
                Log::error('Failed to upgrade pelanggan to member', [
                    'pelanggan_id' => $this->pelanggan_id
                ]);
                return false;
            }
        } catch (\Exception $e) {
            Log::error('Error upgrading pelanggan to member: ' . $e->getMessage(), [
                'pelanggan_id' => $this->pelanggan_id,
                'trace' => $e->getTraceAsString()
            ]);
            return false;
        }
    }

    public function addPoints($amount)
    {
        try {
            // Setiap 500000 rupiah dapat 3 point
            $points = floor($amount / 500000) * 5;

            if ($points > 0) {
                $this->increment('points', $points);

                Log::info('Points added to member', [
                    'pelanggan_id' => $this->pelanggan_id,
                    'amount' => $amount,
                    'points_added' => $points,
                    'total_points' => $this->points + $points
                ]);
            }

            return $points;
        } catch (\Exception $e) {
            Log::error('Error adding points: ' . $e->getMessage(), [
                'pelanggan_id' => $this->pelanggan_id,
                'amount' => $amount
            ]);
            return 0;
        }
    }

    public function getAuthIdentifierName()
    {
        return 'pelanggan_id';
    }
}
