<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderListingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_listings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('status_id');
            $table->string('google_review_url');
            
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('clinic_id')->references('id')->on('clinics');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('provider_id')->references('id')->on('users');
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
        Schema::table('provider_listings', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['location_id']);
            $table->dropForeign(['status_id']);
            
            $table->dropColumn('clinic_id');
            $table->dropColumn('provider_id');
            $table->dropColumn('location_id');
            $table->dropColumn('status_id');
            $table->dropSoftDeletes();
        });


        Schema::dropIfExists('provider_listings');
    }
}
