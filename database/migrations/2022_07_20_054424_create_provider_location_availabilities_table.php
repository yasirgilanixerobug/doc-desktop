<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderLocationAvailabilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_location_availabilities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_location_id');
            $table->string('day_of_week');
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('is_available');
            $table->string('reason_of_unavailability')->nullable();
            $table->timestamps();

            $table->foreign('provider_location_id')->references('id')->on('provider_locations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('provider_location_availabilities', function (Blueprint $table) {
            $table->dropForeign(['provider_location_id']);
            $table->dropColumn('provider_location_id');
        });

        Schema::dropIfExists('provider_location_availabilities');
    }
}
