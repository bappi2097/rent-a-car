<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Models\User;
use App\Models\Car;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Models\CarCategory;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (empty(auth()->user()->company)) {
            Toastr::warning("First update your profile", "Warning");
            return view("company.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("company")->first(),
                "companyTypes" => CompanyType::all(),
            ]);
        }
        return view("company.pages.car.index", [
            "company" => CompanyDetail::where("id", auth()->user()->company->id)->with("cars")->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("company.pages.car.create", [
            "carCategories" => CarCategory::with(["carModelCategory"])->get(),
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
        if (empty(auth()->user()->company)) {
            Toastr::warning("First update your profile", "Warning");
            return view("company.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("company")->first(),
                "companyTypes" => CompanyType::all(),
            ]);
        }
        $company = CompanyDetail::where("id", auth()->user()->company->id)->with("cars")->first();
        $this->validate($request, [
            "car_no" => "required|unique:cars,car_no",
            "car_category_id" => "required|exists:car_categories,id",
            "image" => "required|file",
            "license" => "required|file",
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
            "is_valid" => 0,
        ];

        $car = new Car($data);

        if ($car->save()) {
            $company->cars()->attach($car->id);
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
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit($locale, Car $car)
    {
        return view("company.pages.car.edit", [
            "car" => $car,
            "carCategories" => CarCategory::with(["carModelCategory"])->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update($locale, Request $request, Car $car)
    {
        $this->validate($request, [
            "car_no" => "required|unique:cars,car_no," . $car->id,
            "car_category_id" => "required|exists:car_categories,id",
            "image" => "nullable|file",
            "license" => "nullable|file",
        ]);

        $data = [
            "car_no" => $request->car_no,
            "car_category_id" => $request->car_category_id,
            "is_valid" => 0,
        ];

        if ($request->hasFile('image')) {
            if (Storage::disk("local")->exists($car->image)) {
                Storage::disk("local")->delete($car->image);
            }
            $data['image'] = Storage::disk("local")->put("images\\car\\image", $request->image);
        }


        if ($request->hasFile('license')) {
            if (Storage::disk("local")->exists($car->license)) {
                Storage::disk("local")->delete($car->license);
            }
            $data['license'] = Storage::disk("local")->put("images\\car\\license", $request->license);
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
    public function destroy($locale, Car $car)
    {
        if (Storage::disk("local")->exists($car->image)) {
            Storage::disk("local")->delete($car->image);
        }

        if (Storage::disk("local")->exists($car->license)) {
            Storage::disk("local")->delete($car->license);
        }

        if ($car->delete()) {
            Toastr::success('Car Deleted Successfully', 'Success');
        } else {
            Toastr::error('Something Went Wrong', 'Error');
        }

        return redirect()->back();
    }
}
