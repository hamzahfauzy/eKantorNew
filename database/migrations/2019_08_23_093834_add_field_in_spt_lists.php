<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldInSptLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spt_lists', function (Blueprint $table) {
            //
            $table->string('no_spt');
            $table->date('tanggal');
            $table->integer('lama_waktu');
            $table->date('tanggal_awal');
            $table->date('tanggal_akhir');
            $table->string('tempat_tujuan');
            $table->string('maksud_tujuan');
            $table->text('dasar1');
            $table->text('dasar2');
            $table->text('dasar3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spt_lists', function (Blueprint $table) {
            //
        });
    }
}
