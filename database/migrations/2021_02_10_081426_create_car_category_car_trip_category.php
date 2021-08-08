<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarCategoryCarTripCategory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_category_car_trip_category', function (Blueprint $table) {
            $table->id();
            $table->foreignId("car_category_id")->constrained("car_categories")->onDelete("cascade");
            $table->unsignedBigInteger("car_trip_category_id");
            $table->foreign('car_trip_category_id', "car_category_car_trip_category_trip_id")->references("id")->on("car_trip_categories")->onDelete("cascade");
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
        Schema::dropIfExists('car_category_car_trip_category');
    }
}
