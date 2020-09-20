<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditAppUsersTableByAddingHasLatestUpdates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('app_users', function (Blueprint $table) {
            $table->integer('has_latest_updates')->default(0)->nullable(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('app_users', function (Blueprint $table) {
            $table->dropColumn('has_latest_updates');
        });
    }
}
