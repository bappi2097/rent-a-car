<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CarWeightCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CarWeightCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("admin.pages.car-weight.index", [
            "carWeightCategories" => CarWeightCategory::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.pages.car-weight.create");
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
            'weight' => 'required|numeric',
        ]);

        $data = [
            "name" => $request->name,
            "weight" => $request->weight,
        ];

        $carWeight = new CarWeightCategory($data);

        if ($carWeight->save()) {
            Toastr::success("Car Weight Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarWeightCategory  $carWeightCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarWeightCategory $carWeightCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarWeightCategory  $carWeightCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarWeightCategory $carWeightCategory)
    {
        return view("admin.pages.car-weight.edit", [
            "carWeightCategory" => $carWeightCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarWeightCategory  $carWeightCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarWeightCategory $carWeightCategory)
    {
        $this->validate($request, [
            'name' => "required|string|max:100",
            'weight' => 'required|numeric',
        ]);

        $data = [
            "name" => $request->name,
            "weight" => $request->weight,
        ];
        $carWeightCategory->fill($data);

        if ($carWeightCategory->save()) {
            Toastr::success("Car Weight Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarWeightCategory  $carWeightCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarWeightCategory $carWeightCategory)
    {
        if ($carWeightCategory->delete()) {
            Toastr::success("Car Weight Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
