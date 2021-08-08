<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCoveredCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
    ];
    public function carCategories()
    {
        return $this->hasMany(CarCategory::class, "car_covered_category_id");
    }
}
