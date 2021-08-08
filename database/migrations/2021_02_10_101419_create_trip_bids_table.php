<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripBidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_bids', function (Blueprint $table) {
            $table->id();
            $table->foreignId("trip_id")->constrained("trips")->onDelete("cascade");
            $table->foreignId("car_id")->constrained("cars")->onDelete("cascade");
            $table->double("amount");
            $table->tinyInteger("status")->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_bids');
    }
}
