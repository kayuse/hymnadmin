<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddYearToCategories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sunday_school_categories', function (Blueprint $table) {
            //
            $table->integer('year')->default(2020);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sunday_school_categories', function (Blueprint $table) {
            //
            $table->dropColumn('year');
        });
    }
}
