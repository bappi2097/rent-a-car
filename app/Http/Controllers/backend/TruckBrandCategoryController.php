<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Models\CarBrandCategory;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class CarBrandCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.pages.car-brand.index', [
            "carBrandCategories" => CarBrandCategory::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.car-brand.create');
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

        $carBrandCategory = new CarBrandCategory($data);

        if ($carBrandCategory->save()) {
            Toastr::success("Car Brand Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CarBrandCategory  $carBrandCategory
     * @return \Illuminate\Http\Response
     */
    public function show(CarBrandCategory $carBrandCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CarBrandCategory  $carBrandCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(CarBrandCategory $carBrandCategory)
    {
        return view("admin.pages.car-brand.edit", [
            "carBrandCategory" => $carBrandCategory
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarBrandCategory  $carBrandCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CarBrandCategory $carBrandCategory)
    {
        $this->validate($request, [
            'name' => "required|string|max:100",
        ]);

        $data = [
            "name" => $request->name,
        ];
        $carBrandCategory->fill($data);

        if ($carBrandCategory->save()) {
            Toastr::success("Car Brand Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarBrandCategory  $carBrandCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarBrandCategory $carBrandCategory)
    {
        if ($carBrandCategory->delete()) {
            Toastr::success("Car Brand Deleted Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->back();
    }
}
