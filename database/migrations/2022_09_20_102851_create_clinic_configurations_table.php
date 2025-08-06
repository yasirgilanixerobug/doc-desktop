<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClinicConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clinic_configurations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinic_id');
            $table->boolean('is_send_sms')->default(0);
            $table->boolean('is_send_email')->default(0);
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
        Schema::table('clinic_configurations', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
        });

        Schema::dropIfExists('clinic_configurations');
    }
}
