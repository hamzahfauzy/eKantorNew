<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableFileSuratMasuks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lampiran_surat_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('surat_masuk_id')->unsigned();
            $table->string('file_lampiran_url');
            $table->timestamps();

            $table->foreign('surat_masuk_id')->references('id')->on('surat_masuks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('lampiran_surat_masuks');
    }
}
