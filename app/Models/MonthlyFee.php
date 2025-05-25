<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'house_id',
        'resident_id',
        'month',
        'year',
        'security_fee',
        'cleaning_fee',
        'security_status',
        'cleaning_status',
        'payment_date',
        'payment_method',
        'notes'
    ];

    protected $casts = [
        'payment_date' => 'date',
        'security_fee' => 'decimal:2',
        'cleaning_fee' => 'decimal:2',
    ];

    public function house()
    {
        return $this->belongsTo(House::class);
    }

    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }

    public function getPeriodAttribute()
    {
        return sprintf('%02d/%d', $this->month, $this->year);
    }

    public function getTotalAttribute()
    {
        return $this->security_fee + $this->cleaning_fee;
    }
}