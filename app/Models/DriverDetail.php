<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id", "uuid", "address", "image", "nid", "license", "car_id"
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "user_id");
    }

    public function car()
    {
        return $this->belongsTo(Car::class, "car_id");
    }
    /**
     * Get the user's testimonial.
     */

    public function testimonial()
    {
        return $this->morphOne(Testimonial::class, 'testimonialable');
    }
    public function driverBalanceDetail()
    {
        return $this->hasOne(DriverBalanceDetail::class, "driver_id");
    }
    public function validCar()
    {
        return $this->hasValidCar() ? $this->car : null;
    }

    public function hasCar()
    {
        return !empty($this->car);
    }

    public function hasValidCar()
    {
        return $this->hasCar() ? $this->car->is_valid == 1 : false;
    }

    public function tripBids()
    {
        return $this->hasMany(TripBid::class);
    }
}
