<?php

namespace App\Http\Controllers\backend;

use App\Models\Car;
use App\Models\DriverDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class DriverCarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(DriverDetail $driver)
    {
        // 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(DriverDetail $driver)
    {
        // dd($driver->car()->exists());
        if ($driver->car()->exists()) {
            return view("admin.pages.driver.car.edit", [
                "driver" => $driver,
                "car" => $driver->car,
                "carCategories" => CarCategory::with(["carModelCategory", "carCoveredCategory", "carSizeCategory", "carWeightCategory", "carTripCategories"])->get(),
            ]);
        } else {
            return view("admin.pages.driver.car.create", [
                "driver" => $driver,
                "carCategories" => CarCategory::with(["carModelCategory", "carCoveredCategory", "carSizeCategory", "carWeightCategory", "carTripCategories"])->get(),
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, DriverDetail $driver)
    {
        $this->validate($request, [
            "car_category_id" => "required|exists:car_categories,id",
            "car_no" => "required|string|max:100",
            "license" => "required|file",
            "image" => "required|file",
        ]);


        if ($request->hasFile('image')) {
            $image = Storage::disk("local")->put("images\\car\\image", $request->image);
        }


        if ($request->hasFile('license')) {
            $license = Storage::disk("local")->put("images\\car\\license", $request->license);
        }
        $data = [
            "car_no" => $request->car_no,
            "license" => $license,
            "image" => $image,
            "car_category_id" => $request->car_category_id,
            "is_valid" => 1,
        ];

        $car = new Car($data);

        if ($car->save()) {
            $driver->fill(["car_id" => $car->id]);
            $driver->save();
            Toastr::success('Car Added Successfully', 'Success');
        } else {
            Toastr::error('Something Went Wrong', 'Error');
        }
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show(DriverDetail $driver, Car $car)
    {
        // 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(DriverDetail $driver, Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverDetail $driver, Car $car)
    {
        $this->validate($request, [
            "car_category_id" => "required|exists:car_categories,id",
            "car_no" => "required|string|max:100",
            "license" => "nullable|file",
            "image" => "nullable|file",
        ]);

        $data = [
            "car_no" => $request->car_no,
            "car_category_id" => $request->car_category_id,
        ];

        if ($request->hasFile('image')) {
            if (Storage::disk("local")->exists($car->image)) {
                Storage::disk("local")->delete($car->image);
            }
            $data["image"] = Storage::disk("local")->put("images\\car\\image", $request->image);
        }


        if ($request->hasFile('license')) {
            if (Storage::disk("local")->exists($car->license)) {
                Storage::disk("local")->delete($car->license);
            }
            $data["license"] = Storage::disk("local")->put("images\\car\\license", $request->license);
        }

        $car->fill($data);

        if ($car->save()) {
            Toastr::success('Car Updated Successfully', 'Success');
        } else {
            Toastr::error('Something Went Wrong', 'Error');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(DriverDetail $driver, Car $car)
    {
        //
    }
}
