<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\CarSizeCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

class CarSizeCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.car-size.index', [
            "carSizes" => CarSizeCategory::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.car-size.create');
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
            'size' => 'required|numeric',
        ]);

        $data = [
            "name" => $request->name,
            "size" => $request->size,
        ];

        $carSize = new CarSizeCategory($data);

        if ($carSize->save()) {
            Toastr::success("Car Size Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarSizeCategory  $carSizeCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarSizeCategory $carSizeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarSizeCategory  $carSizeCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarSizeCategory $carSizeCategory)
    {
        return view('admin.pages.car-size.edit', [
            "carSizeCategory" => $carSizeCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarSizeCategory  $carSizeCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarSizeCategory $carSizeCategory)
    {
        $this->validate($request, [
            'name' => "required|string|max:100",
            'size' => 'required|numeric',
        ]);

        $data = [
            "name" => $request->name,
            "size" => $request->size,
        ];

        $carSizeCategory->fill($data);

        if ($carSizeCategory->save()) {
            Toastr::success("Car Size Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarSizeCategory  $carSizeCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarSizeCategory $carSizeCategory)
    {
        if ($carSizeCategory->delete()) {
            Toastr::success("Car Size Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
