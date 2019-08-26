<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSptLists extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spt_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('wilayah_id')->unsigned();
            $table->bigInteger('pimpinan_id')->unsigned();
            $table->timestamps();

            $table->foreign('wilayah_id')->references('id')->on('wilayah_tujuans')->onDelete('cascade');
            $table->foreign('pimpinan_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('spt_lists');
    }
}
