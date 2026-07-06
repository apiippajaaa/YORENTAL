<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalDocument extends Model
{
    use HasFactory;
    protected $fillable = ['car_rental_id', 'file_path', 'original_name'];

    public function rental()
    {
        return $this->belongsTo(CarRental::class);
    }
}
