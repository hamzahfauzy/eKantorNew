<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSuratKeluars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keluars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_group_id')->unsigned();
            $table->bigInteger('pegawai_id')->unsigned();
            $table->string('no_surat');
            $table->date('tanggal');
            $table->string('tujuan');
            $table->string('perihal');
            $table->text('keterangan');
            $table->text('file_surat_url');
            $table->timestamps();

            $table->foreign('sub_group_id')->references('id')->on('sub_groups')->onDelete('cascade');
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
        Schema::dropIfExists('surat_keluars');
    }
}
