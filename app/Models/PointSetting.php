<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Cache;

class PointSetting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'description'];

    protected $casts = [
        'value' => 'integer',
    ];

    /**
     * Set or update a setting value
     */
    public static function setValue($key, $value)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        // Clear cache when setting is updated
        Cache::forget("point_setting_{$key}");
        Cache::forget('all_point_settings');

        return $setting;
    }

    /**
     * Get a setting value with caching
     */
    public static function getValue($key, $default = null)
    {
        return Cache::remember("point_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = static::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Get all settings as key-value pairs with caching
     */
    public static function getAllSettings()
    {
        return Cache::remember('all_point_settings', 3600, function () {
            return static::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Calculate points earned for a transaction amount
     */
    public static function calculateEarnedPoints($transactionAmount)
    {
        $pointsPerTransaction = static::getValue('points_per_transaction', 500000);
        $pointsEarned = static::getValue('points_earned_per_transaction', 5);

        return floor($transactionAmount / $pointsPerTransaction) * $pointsEarned;
    }

    /**
     * Calculate discount amount for given points
     */
    public static function calculateDiscount($points)
    {
        $pointsForDiscount = static::getValue('points_for_discount', 10);
        $discountPerPoints = static::getValue('discount_per_points', 10000);

        $discountBatches = floor($points / $pointsForDiscount);
        return $discountBatches * $discountPerPoints;
    }

    /**
     * Get maximum usable points for a given transaction amount
     */
    public static function getMaxUsablePoints($transactionAmount)
    {
        $pointsForDiscount = static::getValue('points_for_discount', 10);
        $discountPerPoints = static::getValue('discount_per_points', 10000);

        // Maximum discount should not exceed transaction amount
        $maxDiscountBatches = floor($transactionAmount / $discountPerPoints);
        return $maxDiscountBatches * $pointsForDiscount;
    }

    /**
     * Validate if points can be used for discount
     */
    public static function canUsePointsForDiscount($points)
    {
        $pointsForDiscount = static::getValue('points_for_discount', 10);
        return $points >= $pointsForDiscount;
    }

    /**
     * Get point conversion rate (how much rupiah per point)
     */
    public static function getPointConversionRate()
    {
        $pointsPerTransaction = static::getValue('points_per_transaction', 500000);
        $pointsEarned = static::getValue('points_earned_per_transaction', 5);

        return $pointsPerTransaction / $pointsEarned;
    }

    /**
     * Get discount conversion rate (how much discount per point)
     */
    public static function getDiscountConversionRate()
    {
        $pointsForDiscount = static::getValue('points_for_discount', 10);
        $discountPerPoints = static::getValue('discount_per_points', 10000);

        return $discountPerPoints / $pointsForDiscount;
    }

    /**
     * Boot method to clear cache when model is updated or deleted
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            Cache::forget("point_setting_{$model->key}");
            Cache::forget('all_point_settings');
        });

        static::deleted(function ($model) {
            Cache::forget("point_setting_{$model->key}");
            Cache::forget('all_point_settings');
        });
    }

    /**
     * Scope to get specific setting
     */
    public function scopeKey($query, $key)
    {
        return $query->where('key', $key);
    }
}
