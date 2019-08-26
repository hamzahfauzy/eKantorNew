<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSptEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spt_employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('spt_id')->unsigned();
            $table->bigInteger('employee_id')->unsigned();

            $table->foreign('spt_id')->references('id')->on('spt_lists')->onDelete('cascade');
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
        Schema::dropIfExists('spt_employees');
    }
}
