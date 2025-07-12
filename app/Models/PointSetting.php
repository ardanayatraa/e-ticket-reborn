<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'description'
    ];

    /**
     * Get setting value by key
     */
    public static function getValue($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set setting value by key
     */
    public static function setValue($key, $value, $description = null)
    {
        $setting = self::where('key', $key)->first();
        
        if ($setting) {
            $setting->update([
                'value' => $value,
                'description' => $description ?? $setting->description
            ]);
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
                'description' => $description
            ]);
        }
    }

    /**
     * Get all settings as array
     */
    public static function getAllSettings()
    {
        return self::all()->pluck('value', 'key')->toArray();
    }
} 