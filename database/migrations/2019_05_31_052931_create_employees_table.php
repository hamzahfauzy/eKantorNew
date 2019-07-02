<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('NIP');
            $table->string('nama');
            $table->string('jabatan');
            $table->bigInteger('golongan_id')->unsigned()->nullable();
            $table->bigInteger('eselon_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('golongan_id')->references('id')->on('golongans')->onDelete('set null');
            $table->foreign('eselon_id')->references('id')->on('eselons')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
