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
        'email_verified_at',
        // Kolom member payment
        'order_id',
        'amount',
        'payment_status',
        'payment_type',
        'transaction_id',
        'midtrans_response',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'member_since' => 'datetime',
        'is_member' => 'boolean',
        'midtrans_response' => 'array',
        'amount' => 'decimal:2',
    ];

    // Relasi
    public function pemesanans()
    {
        return $this->hasMany(Pemesanan::class, 'pelanggan_id');
    }

    public function transaksis()
    {
        return $this->hasMany(Transaksi::class, 'pelanggan_id');
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

    // Points are now handled automatically by TransaksiObserver
    // when transaction status changes to 'paid'

    public function getAuthIdentifierName()
    {
        return 'pelanggan_id';
    }
}
