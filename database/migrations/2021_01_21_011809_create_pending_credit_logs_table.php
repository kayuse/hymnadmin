<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingCreditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_credit_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('from_user_id')->unsigned();
            $table->string('assigned_to');
            $table->string('reference');
            $table->boolean('claimed');
            $table->integer('reference_id');
            $table->timestamps();
        });
        Schema::table('pending_credit_logs', function (Blueprint $table) {
            $table->foreign('from_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pending_credit_logs');
    }
}
