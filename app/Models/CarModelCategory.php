<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarModelCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "car_brand_category_id", "model"
    ];
    public function carBrandCategory()
    {
        return $this->belongsTo(CarBrandCategory::class, "car_brand_category_id");
    }
    public function carCategories()
    {
        return $this->hasMany(CarCategory::class, "car_model_category_id");
    }
}
