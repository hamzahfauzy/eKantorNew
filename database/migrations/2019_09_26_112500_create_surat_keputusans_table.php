<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSuratKeputusansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_keputusans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pegawai_id')->unsigned();
            $table->string('no_sk');
            $table->date('tanggal');
            $table->string('tentang');
            $table->string('tahun');
            $table->text('file_sk_url');
            $table->text('file_sk_fix_url')->nullable();
            $table->integer('need_action')->default(0);
            $table->string('no_agenda')->default(0);
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
        Schema::dropIfExists('surat_keputusans');
    }
}
