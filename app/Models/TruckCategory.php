<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        "car_weight_category_id", "car_size_category_id", "car_covered_category_id", "car_model_category_id", "description", "image",
    ];

    public function carModelCategory()
    {
        return $this->belongsTo(CarModelCategory::class, "car_model_category_id");
    }
    public function carCoveredCategory()
    {
        return $this->belongsTo(CarCoveredCategory::class, "car_covered_category_id");
    }
    public function carSizeCategory()
    {
        return $this->belongsTo(CarSizeCategory::class, "car_size_category_id");
    }
    public function carWeightCategory()
    {
        return $this->belongsTo(CarWeightCategory::class, "car_weight_category_id");
    }
    public function carTripCategories()
    {
        return $this->belongsToMany(CarTripCategory::class);
    }
    public function car()
    {
        return $this->hasOne(Car::class);
    }
    public function trip()
    {
        return $this->hasOne(Trip::class, "car_category_id");
    }
}
