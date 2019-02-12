<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('records',function(Blueprint $table){
            $table->boolean('disabled')->default(false);
            $table->boolean('enabled')->default(false);
            //default
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::table('records',function(Blueprint $table){
            $table->dropColumn('disabled');
            $table->dropColumn('enabled');
        });
    }
}
