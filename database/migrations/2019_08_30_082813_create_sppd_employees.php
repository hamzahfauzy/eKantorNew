<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSppdEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sppd_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sppd_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();
            $table->integer('no_urut')->unsigned();

            $table->foreign('sppd_id')->references('id')->on('sppd_lists')->onDelete('cascade');
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sppd_employees');
    }
}
