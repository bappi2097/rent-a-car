<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("car_model_category_id")->constrained("car_model_categories")->onDelete("cascade");
            $table->foreignId("car_covered_category_id")->constrained("car_covered_categories")->onDelete("cascade");
            $table->foreignId("car_size_category_id")->constrained("car_size_categories")->onDelete("cascade");
            $table->foreignId("car_weight_category_id")->constrained("car_weight_categories")->onDelete("cascade");
            $table->text("description")->nullable();
            $table->text("image")->nullable();
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
        Schema::dropIfExists('car_categories');
    }
}
