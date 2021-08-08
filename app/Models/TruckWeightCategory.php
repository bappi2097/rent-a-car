<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarWeightCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "weight"
    ];
    public function carCategories()
    {
        return $this->hasMany(CarCategory::class, "car_weight_category_id");
    }
}
