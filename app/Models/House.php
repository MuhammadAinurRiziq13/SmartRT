<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_number',
        'occupancy_status'
    ];

    public function currentResident()
    {
        return $this->hasOne(OccupancyHistory::class)
            ->latestOfMany()
            ->with('resident');
    }

    public function occupancyHistories()
    {
        return $this->hasMany(OccupancyHistory::class);
    }

    public function monthlyFees()
    {
        return $this->hasMany(MonthlyFee::class);
    }
}