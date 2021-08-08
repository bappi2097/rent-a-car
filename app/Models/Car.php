<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        "car_category_id", "car_no", "license", "image", "is_valid"
    ];

    public function company()
    {
        return $this->belongsToMany(CompanyDetail::class);
    }

    public function user()
    {
        if ($this->isCompany()) {
            return $this->company->first()->user();
        } elseif ($this->isDriver()) {
            return $this->driver->user();
        }
    }

    public function carCategory()
    {
        return $this->belongsTo(CarCategory::class);
    }

    public function tripBid()
    {
        return $this->hasMany(TripBid::class, "car_id");
    }

    public function driver()
    {
        return $this->hasOne(DriverDetail::class, "car_id");
    }

    public function isCompany()
    {
        return !$this->company->isEmpty();
    }

    public function isDriver()
    {
        return !empty($this->driver);
    }
}
