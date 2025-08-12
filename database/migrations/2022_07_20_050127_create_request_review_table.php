<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestReviewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->string('slug')->nullable();
            $table->string('patient');
            $table->date('dob')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->date('appointment_date');
            $table->string('provider');
            $table->string('location');
            $table->string('review_url');
            $table->tinyInteger('sms_status')->default(0);
            $table->string('sms_status_message')->nullable();
            $table->timestamps();

            $table->foreign('clinic_id')->references('id')->on('clinics');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_reviews', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropColumn('clinic_id');
        });

        Schema::dropIfExists('request_reviews');
    }
}
