<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSizeCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "name", "size"
    ];
    public function carCategories()
    {
        return $this->hasMany(CarCategory::class, "car_size_category_id");
    }
}
