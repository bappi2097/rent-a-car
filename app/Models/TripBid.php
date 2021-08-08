<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TripBid extends Model
{
    use HasFactory;
    protected $fillable = [
        "trip_id",
        "car_id",
        "amount",
        "status",
    ];

    public function trip()
    {
        return $this->belongsTo(Trip::class, "trip_id");
    }

    public function car()
    {
        return $this->belongsTo(Car::class, "car_id");
    }
    public function isApproved()
    {
        return $this->status == 1;
    }

    public function isDeclined()
    {
        return $this->status == 2;
    }
    public function company()
    {
        return $this->belongsTo(CompanyDetail::class);
    }
    public function approveNotification($text = "", $status = "Approve", $url = "")
    {
        $text = $this->trip->customer->user->name . " Bid " . $status;
        if ($this->car->isDriver()) {
            return $this->car->driver->user->notifications()->save(new Notification([
                "trip_id" => $this->trip_id,
                "trip_bid_id" => $this->id,
                "text" => $text,
                "url" => $url
            ]));
        } else {
            return $this->car->user->notifications()->save(new Notification([
                "trip_id" => $this->trip_id,
                "trip_bid_id" => $this->id,
                "text" => $text,
                "url" => $url
            ]));
        }
    }
}
