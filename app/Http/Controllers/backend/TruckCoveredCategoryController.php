<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarCoveredCategory;
use Brian2694\Toastr\Facades\Toastr;

class CarCoveredCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.car-covered.index', [
            "carCoveredCategories" => CarCoveredCategory::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.car-covered.create');
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
            'name' => "required|string|max:100",
        ]);

        $data = [
            "name" => $request->name,
        ];

        $carCoveredCategory = new CarCoveredCategory($data);

        if ($carCoveredCategory->save()) {
            Toastr::success("Car Covered Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarCoveredCategory  $carCoveredCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarCoveredCategory $carCoveredCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarCoveredCategory  $carCoveredCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarCoveredCategory $carCoveredCategory)
    {
        return view("admin.pages.car-covered.edit", [
            "carCoveredCategory" => $carCoveredCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarCoveredCategory  $carCoveredCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarCoveredCategory $carCoveredCategory)
    {
        $this->validate($request, [
            'name' => "required|string|max:100",
        ]);

        $data = [
            "name" => $request->name,
        ];
        $carCoveredCategory->fill($data);

        if ($carCoveredCategory->save()) {
            Toastr::success("Car Covered Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarCoveredCategory  $carCoveredCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarCoveredCategory $carCoveredCategory)
    {
        if ($carCoveredCategory->delete()) {
            Toastr::success("Car Covered Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
