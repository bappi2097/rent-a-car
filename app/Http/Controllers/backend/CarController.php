<?php

namespace App\Http\Controllers\backend;

use App\Models\User;
use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CarCategory;
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
        return view('admin.pages.car.index', [
            "cars" => Car::orderBy("is_valid")->latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "is_valid" => 1,
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
    public function show(User $user, Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        return view("admin.pages.car.edit", [
            "car" => $car,
            "carCategories" => CarCategory::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Car $car)
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
            "is_valid" => 1,
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
    public function destroy(Car $car)
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

    public function user(Car $car)
    {
        if ($car->isCompany()) {
            return redirect()->route("admin.user.company.show", $car->company->first()->user_id);
        } else {
            return redirect()->route("admin.user.driver.show", $car->driver->user_id);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function accept(Request $request, Car $car)
    {
        if ($car->update(["is_valid" => 1])) {
            if ($car->isCompany()) {
                $car->user->setNotification($car->id, "Your Car Validation Complete : Accepted", route("company.car.index", "en"));
            } else {
                $car->user->setNotification($car->id, "Your Car Validation Complete : Accepted", route("driver.car.show", "en"));
            }
            Toastr::success("Car is valid now", "Success");
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function reject(Request $request, Car $car)
    {
        if ($car->update(["is_valid" => 2])) {
            if ($car->isCompany()) {
                $car->user->setNotification($car->id, "Your Car Validation Complete : Rejected", route("company.car.index", "en"));
            } else {
                $car->user->setNotification($car->id, "Your Car Validation Complete : Rejected", route("driver.car.show", "en"));
            }
            Toastr::success("Car is rejected now", "Success");
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }
        return redirect()->back();
    }
}
