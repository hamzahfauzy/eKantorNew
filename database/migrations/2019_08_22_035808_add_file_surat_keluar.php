<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFileSuratKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_keluars', function (Blueprint $table) {
            //
            $table->string('file_surat_fix_url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_keluars', function (Blueprint $table) {
            //
            $table->dropColumn('file_surat_fix_url');
        });
    }
}
