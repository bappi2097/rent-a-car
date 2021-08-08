<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CarTripCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CarTripCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.pages.car-trip.index", [
            "carTripCategories" => CarTripCategory::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.car-trip.create");
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
            "name" => "required|string|max:100|unique:car_trip_categories,name",
        ]);

        $data = [
            "name" => $request->name,
        ];

        $carTripCategory = new CarTripCategory($data);

        if ($carTripCategory->save()) {
            Toastr::success("Car Trip Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarTripCategory  $carTripCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarTripCategory $carTripCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarTripCategory  $carTripCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarTripCategory $carTripCategory)
    {
        return view("admin.pages.car-trip.edit", [
            "carTripCategory" => $carTripCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarTripCategory  $carTripCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarTripCategory $carTripCategory)
    {
        $this->validate($request, [
            "name" => "required|string|max:100|unique:car_trip_categories,name," . $carTripCategory->id,
        ]);

        $data = [
            "name" => $request->name,
        ];

        $carTripCategory->fill($data);

        if ($carTripCategory->save()) {
            Toastr::success("Car Trip Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarTripCategory  $carTripCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarTripCategory $carTripCategory)
    {
        if ($carTripCategory->delete()) {
            Toastr::success("Car Trip Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
