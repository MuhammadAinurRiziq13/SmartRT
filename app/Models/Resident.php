<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resident extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'full_name',
        'id_card_photo',
        'resident_status',
        'phone_number',
        'marital_status'
    ];

    public function houses()
    {
        return $this->belongsToMany(House::class, 'occupancy_histories')
            ->withPivot(['move_in_date', 'occupancy_type'])
            ->withTimestamps();
    }

    public function monthlyFees()
    {
        return $this->hasMany(MonthlyFee::class);
    }
}