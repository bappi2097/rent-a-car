<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarTripCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
    ];

    public function carCategories()
    {
        return $this->belongsToMany(CarCategory::class);
    }
}
