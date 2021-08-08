<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\CarCategory;
use App\Models\CarSizeCategory;
use App\Models\CarModelCategory;
use App\Models\CarWeightCategory;
use App\Http\Controllers\Controller;
use App\Models\CarCoveredCategory;
use App\Models\CarTripCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class CarCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.pages.car-category.index", [
            "carCategories" => CarCategory::with('carModelCategory')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.car-category.create', [
            "carModelCategories" => CarModelCategory::all(),
            "carCoveredCategories" => CarCoveredCategory::all(),
            "carSizeCategories" => CarSizeCategory::all(),
            "carWeightCategories" => CarWeightCategory::all(),
            "carTripCategories" => CarTripCategory::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'description' => "nullable|string",
            'car_model_category_id' => "exists:car_model_categories,id",
            'car_weight_category_id' => "exists:car_weight_categories,id",
            'car_size_category_id' => "exists:car_size_categories,id",
            'car_covered_category_id' => "exists:car_covered_categories,id",
            'car_trip_category_id' => "required|array",
            'image' => "required|file",
        ]);
        if ($request->hasFile("image")) {
            $image = Storage::disk("local")->put("images\\car", $request->image);
        }
        $data = [
            "description" => $request->description ?: "",
            "car_model_category_id" => $request->car_model_category_id,
            "car_weight_category_id" => $request->car_weight_category_id,
            "car_size_category_id" => $request->car_size_category_id,
            "car_covered_category_id" => $request->car_covered_category_id,
            "image" => $image,
        ];

        $carCategory = new CarCategory($data);

        if ($carCategory->save()) {
            $carCategory->carTripCategories()->sync($request->car_trip_category_id);
            Toastr::success("Car Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarCategory  $carCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarCategory $carCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarCategory  $carCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarCategory $carCategory)
    {
        return view('admin.pages.car-category.edit', [
            "carCategory" => $carCategory,
            "carModelCategories" => CarModelCategory::all(),
            "carCoveredCategories" => CarCoveredCategory::all(),
            "carSizeCategories" => CarSizeCategory::all(),
            "carTripCategories" => CarTripCategory::all(),
            "carWeightCategories" => CarWeightCategory::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarCategory  $carCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarCategory $carCategory)
    {
        $this->validate($request, [
            'description' => "nullable|string",
            'car_model_category_id' => "exists:car_model_categories,id",
            'car_weight_category_id' => "exists:car_weight_categories,id",
            'car_size_category_id' => "exists:car_size_categories,id",
            'car_covered_category_id' => "exists:car_covered_categories,id",
            'car_trip_category_id' => "required|array",
            'image' => "nullable|file",
        ]);

        $data = [
            "description" => $request->description ?: "",
            "car_model_category_id" => $request->car_model_category_id,
            "car_weight_category_id" => $request->car_weight_category_id,
            "car_size_category_id" => $request->car_size_category_id,
            "car_covered_category_id" => $request->car_covered_category_id,
        ];

        if ($request->hasFile('image')) {
            if (Storage::disk("local")->exists($carCategory->image)) {
                Storage::disk("local")->delete($carCategory->image);
            }
            $data["image"] = Storage::disk("local")->put("images\\car", $request->image);
        }

        $carCategory->fill($data);
        if ($carCategory->save()) {
            $carCategory->carTripCategories()->sync($request->car_trip_category_id);
            Toastr::success("Car Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarCategory  $carCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarCategory $carCategory)
    {
        if (Storage::disk("local")->exists($carCategory->image)) {
            Storage::disk("local")->delete($carCategory->image);
        }
        if ($carCategory->delete()) {
            Toastr::success("Car Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
