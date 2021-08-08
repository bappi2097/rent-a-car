<?php

namespace App\Http\Controllers\Frontend\Page;

use App\Models\HeaderSlider;
use Illuminate\Http\Request;
use App\Models\CarCategory;
use App\Http\Controllers\Controller;

class CarOperatorController extends Controller
{
    public function index()
    {
        return view('car-operator', [
            "carCategories" => CarCategory::with("carWeightCategory")->latest()->take(12)->get(),
            "sliders" => HeaderSlider::where("category", "car-operator")->get()
        ]);
    }
}
