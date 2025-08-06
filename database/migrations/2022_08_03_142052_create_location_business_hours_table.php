<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocationBusinessHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('location_business_hours', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->string('day_of_week');
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('is_available');
            $table->string('reason_of_unavailability')->nullable();
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('location_business_hours', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropColumn('location_id');
        });

        Schema::dropIfExists('location_business_hours');
    }
}
