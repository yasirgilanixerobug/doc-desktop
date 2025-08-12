<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('appointment_id');
            $table->unsignedBigInteger('provider_id');
            $table->morphs('userable');
            $table->string('name')->nullable();
            $table->integer('rating');
            $table->text('comment');
            $table->boolean('approved')->default(0);
            $table->boolean('spam')->default(0);

            $table->boolean('is_review_anonymous')->default(1);
            $table->tinyInteger('wait_time_rating')->nullable();
            $table->tinyInteger('bedside_manner_rating')->nullable();
            $table->boolean('is_doctor_recommended')->default(1);

            $table->timestamps();

            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('provider_id')->references('id')->on('users');
            $table->foreign('appointment_id')->references('id')->on('appointments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['appointment_id']);
            $table->dropColumn('clinic_id');
            $table->dropColumn('provider_id');
            $table->dropColumn('appointment_id');
        });

        Schema::dropIfExists('reviews');
    }
}
