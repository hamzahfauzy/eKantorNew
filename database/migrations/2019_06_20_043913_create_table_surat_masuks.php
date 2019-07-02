<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuratMasuks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pegawai_id')->unsigned();
            $table->string('no_agenda');
            $table->string('no_surat');
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->string('sumber_surat');
            $table->string('perihal');
            $table->text('keterangan');
            $table->text('file_url_surat');
            $table->timestamps();

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
        Schema::dropIfExists('surat_masuks');
    }
}
