<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Models\Trip;
use App\Models\User;
use App\Models\TripBid;
use App\Models\CompanyType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class BidController extends Controller
{
    public function show($locale, Trip $trip)
    {
        if (empty(auth()->user()->company)) {
            Toastr::warning("First update your profile", "Warning");
            return view("company.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("company")->first(),
                "companyTypes" => CompanyType::all(),
            ]);
        }
        return view("company.pages.trip.make-bid", [
            "trip" => $trip,
            "cars" => auth()->user()->company->cars,
        ]);
    }
    public function create($locale, Request $request, Trip $trip)
    {
        $this->validate($request, [
            "amount" => "required",
            "car_id" => "required|exists:cars,id",
        ]);

        $data = [
            "car_id" => $request->car_id,
            "amount" => $request->amount,
            "status" => 0,
            "trip_id" => $trip->id
        ];

        $tripBid = new TripBid($data);
        if ($tripBid->save()) {
            $trip->addCustomerNotification(
                $tripBid,
                route("customer.make-trip.show-trip", $trip->id),
                $tripBid->car->company->first()->user->name . " make bid for Trip<br> Amount: " . $tripBid->amount
            );
            Toastr::success("TripBid Successfully Added", "Success");
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }
        return redirect()->back();
    }
}
