<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarBrandCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "name"
    ];
    public function carModelCategories()
    {
        return $this->hasMany(CarModelCategory::class, "car_brand_category_id");
    }
}
