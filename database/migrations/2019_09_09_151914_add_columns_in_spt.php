<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsInSpt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('spt_lists', function (Blueprint $table) {
            //
            $table->integer('need_action')->default(0);
            $table->string('file_spt_fix_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('spt_lists', function (Blueprint $table) {
            //
            $table->dropColumn('need_action');
            $table->dropColumn('file_spt_fix_url');
        });
    }
}
