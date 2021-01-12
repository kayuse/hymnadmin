<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestCopiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_copies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('reference_id')->nullable(false);
            $table->integer('user_id')->unsigned();
            $table->string('copy_reference')->nullable(false);
            $table->timestamps();
        });
        Schema::table('request_copies', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('request_copies');
    }
}
