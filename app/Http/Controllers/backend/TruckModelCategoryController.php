<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\CarBrandCategory;
use App\Models\CarModelCategory;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CarModelCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.car-model.index', [
            "carModelCategories" => CarModelCategory::with('carBrandCategory')->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.car-model.create', [
            "carBrandCategories" => CarBrandCategory::all()
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
            'model' => "required|string|max:100",
            'car_brand_category_id' => "exists:car_brand_categories,id",
        ]);

        $data = [
            "model" => $request->model,
            "car_brand_category_id" => $request->car_brand_category_id,
        ];

        $carModelCategory = new CarModelCategory($data);

        if ($carModelCategory->save()) {
            Toastr::success("Car Model Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarModelCategory  $carModelCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarModelCategory $carModelCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarModelCategory  $carModelCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarModelCategory $carModelCategory)
    {
        return view('admin.pages.car-model.edit', [
            'carModelCategory' => $carModelCategory,
            'carBrandCategories' => CarBrandCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarModelCategory  $carModelCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarModelCategory $carModelCategory)
    {
        $this->validate($request, [
            'model' => "required|string|max:100",
            'car_brand_category_id' => "exists:car_brand_categories,id",
        ]);

        $data = [
            "model" => $request->model,
            "car_brand_category_id" => $request->car_brand_category_id,
        ];

        $carModelCategory->fill($data);
        if ($carModelCategory->save()) {
            Toastr::success("Car Model Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarModelCategory  $carModelCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarModelCategory $carModelCategory)
    {
        if ($carModelCategory->delete()) {
            Toastr::success("Car Model Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
