<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColorInClinicConfigurationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clinic_configurations', function (Blueprint $table) {
            $table->string('background_color')->default(null)->after('id');
            $table->string('color')->default(null)->after('id');
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
            $table->dropColumn('background_color');
            $table->dropColumn('color');
        });
    }
}
