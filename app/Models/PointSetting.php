<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class PointSetting extends Model
{
    use HasFactory;

    protected $primaryKey = 'point_id';
    protected $fillable = [
        'nama_season_point',
        'minimum_transaksi',
        'jumlah_point_diperoleh',
        'harga_satuan_point',
        'is_active'
    ];

    protected $casts = [
        'minimum_transaksi' => 'integer',
        'jumlah_point_diperoleh' => 'integer',
        'harga_satuan_point' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Get active point settings
     */
    public static function getActiveSettings()
    {
        return Cache::remember('active_point_settings', 3600, function () {
            return static::where('is_active', true)->get();
        });
    }

    /**
     * Get point setting by minimum transaction amount
     */
    public static function getSettingByTransactionAmount($amount)
    {
        return static::where('is_active', true)
            ->where('minimum_transaksi', '<=', $amount)
            ->orderBy('minimum_transaksi', 'desc')
            ->first();
    }

    /**
     * Get the best setting for a transaction amount (highest minimum that applies)
     */
    public static function getBestSettingForAmount($amount)
    {
        $setting = static::getSettingByTransactionAmount($amount);
        
        if (!$setting) {
            // Return the lowest minimum setting if no applicable setting found
            return static::where('is_active', true)
                ->orderBy('minimum_transaksi', 'asc')
                ->first();
        }
        
        return $setting;
    }

    /**
     * Calculate points earned for a transaction amount
     */
    public static function calculateEarnedPoints($transactionAmount)
    {
        $setting = static::getSettingByTransactionAmount($transactionAmount);
        
        if (!$setting) {
            return 0;
        }

        return floor($transactionAmount / $setting->minimum_transaksi) * $setting->jumlah_point_diperoleh;
    }

    /**
     * Calculate discount amount for given points
     */
    public static function calculateDiscount($points)
    {
        $activeSettings = static::getActiveSettings();
        
        if ($activeSettings->isEmpty()) {
            return 0;
        }

        // Use the first active setting for discount calculation
        $setting = $activeSettings->first();
        $discountBatches = floor($points / $setting->jumlah_point_diperoleh);
        return $discountBatches * $setting->harga_satuan_point;
    }

    /**
     * Get maximum usable points for a given transaction amount
     */
    public static function getMaxUsablePoints($transactionAmount)
    {
        $activeSettings = static::getActiveSettings();
        
        if ($activeSettings->isEmpty()) {
            return 0;
        }

        $setting = $activeSettings->first();
        
        // Maximum discount should not exceed transaction amount
        $maxDiscountBatches = floor($transactionAmount / $setting->harga_satuan_point);
        return $maxDiscountBatches * $setting->jumlah_point_diperoleh;
    }

    /**
     * Validate if points can be used for discount
     */
    public static function canUsePointsForDiscount($points)
    {
        $activeSettings = static::getActiveSettings();
        
        if ($activeSettings->isEmpty()) {
            return false;
        }

        $setting = $activeSettings->first();
        return $points >= $setting->jumlah_point_diperoleh;
    }

    /**
     * Get point conversion rate (how much rupiah per point)
     */
    public static function getPointConversionRate()
    {
        $setting = static::getActiveSettings()->first();
        
        if (!$setting) {
            return 0;
        }

        return $setting->minimum_transaksi / $setting->jumlah_point_diperoleh;
    }

    /**
     * Get discount conversion rate (how much discount per point)
     */
    public static function getDiscountConversionRate()
    {
        $setting = static::getActiveSettings()->first();
        
        if (!$setting) {
            return 0;
        }

        return $setting->harga_satuan_point / $setting->jumlah_point_diperoleh;
    }

    /**
     * Boot method to clear cache when model is updated or deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget('active_point_settings');
        });

        static::deleted(function ($model) {
            Cache::forget('active_point_settings');
        });
    }

    /**
     * Scope to get active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get settings by minimum transaction
     */
    public function scopeByMinimumTransaction($query, $amount)
    {
        return $query->where('minimum_transaksi', '<=', $amount);
    }
}
