<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPdfSerialize extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('histori_surat_keluars', function (Blueprint $table) {
            //
            $table->longText('pdf_serialize')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('histori_surat_keluars', function (Blueprint $table) {
            //
            $table->dropColumn('pdf_serialize');
        });
    }
}
