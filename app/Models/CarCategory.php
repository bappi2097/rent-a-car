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
    public function car()
    {
        return $this->hasOne(Car::class);
    }
    public function trip()
    {
        return $this->hasOne(Trip::class, "car_category_id");
    }
}
