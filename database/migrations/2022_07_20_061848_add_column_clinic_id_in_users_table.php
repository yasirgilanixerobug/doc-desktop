<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnClinicIdInUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('clinic_id')->after('id')->nullable();
            $table->unsignedBigInteger('status_id')->after('remember_token')->nullable();
            $table->foreign('clinic_id')->references('id')->on('clinics');
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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['clinic_id']);
            $table->dropForeign(['status_id']);
            $table->dropColumn('clinic_id');
            $table->dropColumn('status_id');
        });
    }
}
