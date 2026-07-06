<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_category_id',
        'name',
        'plate_number',
        'year',
        'seats',
        'transmission',
        'color',
        'price_per_12_hours',
        'price_per_day',

        'description',
    ];

    public function category()
    {
        return $this->belongsTo(CarCategory::class, 'car_category_id');
    }

    public function photos()
    {
        return $this->hasMany(CarPhoto::class);
    }

    public function rentals()
    {
        return $this->hasMany(CarRental::class);
    }
}
