<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiayaInSppdEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sppd_employees', function (Blueprint $table) {
            //
            $table->string('uang_harian');
            $table->string('representatif');
            $table->string('transport');
            $table->string('penginapan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sppd_employees', function (Blueprint $table) {
            //
            $table->dropColumn('uang_harian');
            $table->dropColumn('representatif');
            $table->dropColumn('transport');
            $table->dropColumn('penginapan');
        });
    }
}
