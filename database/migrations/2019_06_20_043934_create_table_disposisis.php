<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableDisposisis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('surat_masuk_id')->unsigned();
            $table->bigInteger('pegawai_id')->unsigned();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->foreign('surat_masuk_id')->references('id')->on('surat_masuks')->onDelete('cascade');
            $table->foreign('pegawai_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisis');
    }
}
