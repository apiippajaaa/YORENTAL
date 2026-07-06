<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarRental extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'user_id',
        'start_date',
        'end_date',
        'total_price',
        'status',
        'duration_type',
        'custom_duration',
        'with_driver',
        'driver_days',
        'with_fuel',
        'fuel_days',
        'discount',
    ];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function documents()
    {
        return $this->hasMany(RentalDocument::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOriginalPriceAttribute()
    {
        return $this->total_price + $this->discount;
    }
}
