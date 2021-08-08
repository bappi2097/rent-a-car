<?php

namespace App\Http\Controllers\Frontend\Driver;

use App\Http\Controllers\Controller;
use App\Models\DriverDetail;
use App\Models\Car;
use App\Models\CarCategory;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        if (empty(auth()->user()->driver)) {
            Toastr::warning("Please Complete Your Profile", "Warning");
            return redirect()->route("driver.my-profile.show");
        }
        $car = auth()->user()->driver->car;
        if (empty($car)) {
            return view("driver.pages.car.create", [
                "carCategories" => CarCategory::with(["carModelCategory", "carCoveredCategory", "carSizeCategory", "carWeightCategory", "carTripCategories"])->get(),
            ]);
        }
        return view("driver.pages.car.show", [
            "car" => $car
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $locale)
    {
        $this->validate($request, [
            "image" => "required|file",
            "car_category_id" => "required|exists:car_categories,id",
            "license" => "required|file",
            "car_no" => "required|string",
        ]);

        $data = [
            "image" => $request->hasFile('image') ? Storage::disk("local")->put("images\\car\\image", $request->image) : "",
            "license" => $request->hasFile('license') ? Storage::disk("local")->put("images\\car\\license", $request->license) : "",
            "car_category_id" => $request->car_category_id,
            "car_no" => $request->car_no,
            "is_valid" => 0,
        ];
        $driver = DriverDetail::find(auth()->user()->driver->id)->with("car")->first();
        $car = new Car($data);
        if ($car->save()) {
            $driver->update(["car_id" => $car->id]);
            Toastr::success("Car Added Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->route("driver.car.show");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, Car $car)
    {
        return view("driver.pages.car.edit", [
            "car" => $car,
            "carCategories" => CarCategory::with(["carModelCategory", "carCoveredCategory", "carSizeCategory", "carWeightCategory", "carTripCategories"])->get(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $locale, Car $car)
    {
        $this->validate($request, [
            "image" => "nullable|file",
            "car_category_id" => "required|exists:car_categories,id",
            "license" => "nullable|file",
            "car_no" => "required|string",
        ]);

        $data = [
            "car_category_id" => $request->car_category_id,
            "car_no" => $request->car_no,
            "is_valid" => 0,
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
            Toastr::success("Car Updated Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong!", "Error");
        }
        return redirect()->route("driver.car.show");
    }
}
