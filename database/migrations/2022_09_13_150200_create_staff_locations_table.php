<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('staff_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('staff_id')->references('id')->on('users');
            $table->foreign('status_id')->references('id')->on('statuses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff_locations', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['staff_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('staff_id');
            $table->dropColumn('status_id');
        });

        Schema::dropIfExists('staff_locations');
    }
}
