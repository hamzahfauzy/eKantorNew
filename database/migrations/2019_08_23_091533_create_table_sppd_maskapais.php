<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSppdMaskapais extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppd_maskapais', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sppd_id')->unsigned();
            $table->string('nama_maskapai');
            $table->string('no_tiket');
            $table->string('id_booking');
            $table->date('tanggal_checkin');
            $table->string('harga_tiket');
            $table->integer('status_keberangkatan');
            $table->timestamps();

            $table->foreign('sppd_id')->references('id')->on('sppd_lists')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppd_maskapais');
    }
}
