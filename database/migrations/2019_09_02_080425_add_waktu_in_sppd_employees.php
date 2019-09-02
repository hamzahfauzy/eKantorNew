<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddWaktuInSppdEmployees extends Migration
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
            $table->integer('lama_waktu')->default(1);
            $table->integer('lama_penginapan')->default(1);
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
            $table->dropColumn('lama_waktu');
            $table->dropColumn('lama_penginapan');
        });
    }
}
