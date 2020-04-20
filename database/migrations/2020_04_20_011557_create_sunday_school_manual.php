<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSundaySchoolManual extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sunday_school_manuals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('language');
            $table->integer('year');
            $table->integer('user_id');
            $table->timestamps();
        });
        Schema::table('sunday_school_topics', function (Blueprint $table) {
            $table->dropColumn('year');
            $table->integer('manual_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sunday_school_manuals');
        Schema::table('sunday_school_topics', function (Blueprint $table) {
            $table->integer('year');
            $table->dropColumn('manual_id');
        });
    }
}
