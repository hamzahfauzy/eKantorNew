<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSppdLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppd_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spt_id')->unsigned();
            $table->bigInteger('kegiatan_id')->unsigned();
            $table->bigInteger('transportation_id')->unsigned();
            $table->date('tanggal');
            $table->string('no_sppd');
            $table->string('uang_harian');
            $table->string('representatif');
            $table->string('transport');
            $table->string('penginapan');
            $table->string('asal');
            $table->string('tujuan');
            $table->timestamps();

            $table->foreign('spt_id')->references('id')->on('spt_lists')->onDelete('cascade');
            $table->foreign('kegiatan_id')->references('id')->on('kegiatans')->onDelete('cascade');
            $table->foreign('transportation_id')->references('id')->on('transportations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppd_lists');
    }
}
