<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProviderLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provider_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('status_id');
            $table->timestamps();

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
        Schema::table('provider_locations', function (Blueprint $table) {
            $table->dropForeign(['location_id']);
            $table->dropForeign(['provider_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn('location_id');
            $table->dropColumn('provider_id');
            $table->dropColumn('status_id');
        });

        Schema::dropIfExists('provider_locations');
    }
}
