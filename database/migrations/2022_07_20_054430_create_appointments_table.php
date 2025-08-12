<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('provider_id');
            $table->morphs('userable');
            $table->string('start_time');
            $table->string('actual_end_time')->nullable();
            $table->unsignedBigInteger('app_booking_channel_id');
            $table->unsignedBigInteger('appointment_status_id');
            $table->date('date');
            $table->text('comment')->nullable();
            $table->string('other_name')->nullable();
            $table->timestamps();

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('provider_id')->references('id')->on('users');
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
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['location_id']);
            $table->dropColumn('clinic_id');
            $table->dropColumn('provider_id');
            $table->dropColumn('location_id');
            $table->dropMorphs('userable');
        });

        Schema::dropIfExists('appointments');
    }
}
