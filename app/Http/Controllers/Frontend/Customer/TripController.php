<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Models\Trip;
use App\Models\Product;
use App\Models\ProductValue;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;

class TripController extends Controller
{
    public function indexCurrent()
    {
        return view("user.pages.trip.current-trip", [
            "trips" => Trip::where("customer_id", auth()->user()->customer->id)->whereNotIn("status",  [2, 3])->with(["carCategory", "tripBids"])->latest()->get()
        ]);
    }

    public function indexHistory()
    {
        return view("user.pages.trip.history-trip", [
            "trips" => Trip::where("customer_id", auth()->user()->customer->id)->whereIn("status",  [2, 3])->with(["carCategory", "tripBids"])->latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        if (empty(auth()->user()->customer)) {
            Toastr::warning("First update your profile", "Warning");
            return view("user.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("customer")->first(),
            ]);
        }
        $this->validate($request, [
            "load_location" => "required|string",
            "unload_location" => "required|string",
            "load_time" => "required",
            "car_category_id" => "required"
        ]);

        $tripData = [
            "customer_id" => auth()->user()->customer->id,
            "car_category_id" => $request->car_category_id,
            "load_location" => $request->load_location,
            "unload_location" => $request->unload_location,
            "load_time" => $request->load_time,
            "status" => 0,
        ];
        $trip = new Trip($tripData);
        if ($trip->save()) {
            Toastr::success("Wow, You make a Trip", "Success");
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }

        return redirect()->back();
    }

    public function showTrip($locale, Trip $trip)
    {
        return view("user.pages.trip.single-current", [
            "trip" => $trip
        ]);
    }
    public function cancel($locale, Trip $trip)
    {
        if ($trip->update(["status" => 2])) {
            Toastr::success("Trip Canceled Successfully", "Success");
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }
        return redirect()->back();
    }
}
