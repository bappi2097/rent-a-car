<?php

namespace App\Http\Controllers\Frontend\Driver;

use App\Models\Trip;
use App\Models\User;
use App\Models\Car;
use App\Models\Product;
use App\Models\ProductValue;
use Illuminate\Http\Request;
use App\Models\DriverBalanceDetail;
use App\Http\Controllers\Controller;
use App\Models\Notification;
use Brian2694\Toastr\Facades\Toastr;

class TripController extends Controller
{
    public function indexCurrent()
    {
        if (empty(auth()->user()->driver)) {
            Toastr::warning("First update your profile", "Warning");
            return view("driver.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("driver")->first(),
            ]);
        }
        $datas = \DB::table("driver_details")
            ->where("driver_details.id", auth()->user()->driver->id)
            ->where("trips.status", 1)
            ->join("cars", "driver_details.car_id", "cars.id")
            ->join("trip_bids", "cars.id", "=", "trip_bids.car_id")
            ->join("trips", "trip_bids.trip_id", "=", "trips.id")
            ->select(
                "trips.id as id",
                "driver_details.id as driver_id",
                "trips.load_location as load_location",
                "trips.unload_location as unload_location",
                "trips.load_time as load_time",
                "trips.status as trip_status",
                "trip_bids.status as trip_bid_status"
            )->get();
        return view("driver.pages.trip.current-trip", [
            "trips" => $datas
        ]);
    }

    public function indexHistory()
    {
        if (empty(auth()->user()->driver)) {
            Toastr::warning("First update your profile", "Warning");
            return view("driver.pages.profile", [
                "user" => User::where("id", auth()->user()->id)->with("driver")->first(),
            ]);
        }
        $datas = \DB::table("driver_details")
            ->where("driver_details.id", auth()->user()->driver->id)
            ->where("trips.status", 3)
            ->join("cars", "driver_details.car_id", "cars.id")
            ->join("trip_bids", "cars.id", "=", "trip_bids.car_id")
            ->join("trips", "trip_bids.trip_id", "=", "trips.id")
            ->select(
                "trips.id as id",
                "driver_details.id as driver_id",
                "trips.load_location as load_location",
                "trips.unload_location as unload_location",
                "trips.load_time as load_time",
                "trips.status as trip_status",
                "trip_bids.status as trip_bid_status",
                "cars.id as car_id",
            )->get();
        $datas = $datas->map(function ($data) {
            $data->car = Car::where("id", $data->car_id)->first();
            return $data;
        });
        return view("driver.pages.trip.history-trip", [
            "trips" => $datas
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            "load_location" => "required|string",
            "unload_location" => "required|string",
            "load_time" => "required",
            "car_category_id" => "required",
            "products_description" => "required|string",
            "product_types" => "nullable|array",
            "worker" => "nullable",
        ]);

        $productData = [
            "description" => $request->products_description,
            "worker" => $request->worker ? true : false,
        ];

        $product = new Product($productData);
        if ($product->save()) {
            if (!empty($request->product_types)) {
                foreach ($request->product_types as $key => $productType) {
                    $productValueData = [
                        "product_type_id" => $key
                    ];
                    $product->productValues()->save(new ProductValue($productValueData));
                }
            }
            $tripData = [
                "product_id" => $product->id,
                "company_id" => auth()->user()->driver->id,
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
                $product->productValues()->delete();
                $product->delete();
                Toastr::error("Something Went Wrong", "Error");
            }
        } else {
            Toastr::error("Something Went Wrong", "Error");
        }

        return redirect()->back();
    }

    public function showTrip($locale, Trip $trip)
    {
        return view("driver.pages.trip.single-trip", [
            "trip" => $trip
        ]);
    }
    public function finish(Request $request, $locale, Trip $trip)
    {
        $driver = auth()->user()->driver;
        if ($trip->update(["status" => 3])) {
            if (empty($driver->balanceDetail)) {
                $balance = new DriverBalanceDetail(["driver_id" => $driver->id, "balance" => $trip->approvedBid()->amount, "trip_no" => 1]);
                $balance->save();
            } else {
                $driver->balanceDetail->increment("trip_no");
                $driver->balanceDetail->balance = $driver->balanceDetail->balance + $trip->approvedBid()->amount;
                $driver->balanceDetail->save();
            }
            $trip->user->notifications()->save(new Notification([
                "trip_id" => $trip->id,
                "text" => "Trip Successfully Finished",
                "url" => route("customer.make-trip.show-trip", $trip->id)
            ]));
            Toastr::success("Trip Successfully Finished", "Success");
        } else {
            Toastr::success("Something Went Wrong", "Error");
        }
        return redirect()->back();
    }
}
