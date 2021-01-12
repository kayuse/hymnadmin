<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSundaySchoolManualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_sunday_school_manuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->bigInteger('manual_id')->unsigned();
            $table->integer('copy')->nullable(false);
            $table->timestamps();
        });
        Schema::table('user_sunday_school_manuals', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('manual_id')->references('id')->on('sunday_school_manuals');
        });
        Schema::table('sunday_school_manuals', function (Blueprint $table) {
            $table->integer('is_free')->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_sunday_school_manuals');
        Schema::table('sunday_school_manuals', function (Blueprint $table) {
            $table->dropColumn('is_free');
        });
    }
}
