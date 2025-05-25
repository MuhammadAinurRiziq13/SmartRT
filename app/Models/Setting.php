<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'default_security_fee',
        'default_cleaning_fee',
        'current_year',
        'rt_name',
        'neighborhood_name'
    ];

    protected $casts = [
        'default_security_fee' => 'decimal:2',
        'default_cleaning_fee' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saved(function () {
            Cache::forget('settings'); // Now properly referenced
        });
    }

    public static function getSettings()
    {
        return Cache::rememberForever('settings', function () { // Now properly referenced
            return self::firstOrCreate([], [
                'default_security_fee' => 100000,
                'default_cleaning_fee' => 15000,
                'current_year' => date('Y'),
                'rt_name' => 'Ketua RT',
                'neighborhood_name' => 'Perumahan Elite'
            ]);
        });
    }
}