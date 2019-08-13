<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLampiranSuratKeluars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            //
            $table->string('jumlah_lampiran')->default(0);
            $table->string('satuan_lampiran')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_masuks', function (Blueprint $table) {
            //
            $table->dropColumn('jumlah_lampiran');
            $table->dropColumn('satuan_lampiran');
        });
    }
}
