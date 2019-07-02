<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubGroupStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_group_staffs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('sub_group_id')->unsigned();
            $table->bigInteger('pegawai_id')->unsigned();
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
        Schema::dropIfExists('sub_group_staff');
    }
}
