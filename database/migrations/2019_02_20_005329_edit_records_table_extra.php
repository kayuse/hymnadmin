<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRecordsTableExtra extends Migration
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
            $table->text('extra')->nullable(true)->change();
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
        Schema::table('records',function(Blueprint $table){
            $table->string('extra')->nullable(true)->change();
        });
    }
}
