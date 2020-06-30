<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPodcastsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('podcast_comments', function (Blueprint $table) {
            $table->string('text');
            $table->string('user_id');
            $table->string('media')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('podcast_comments', function (Blueprint $table) {
            $table->dropColumn('text');
            $table->dropColumn('user_id');
            $table->string('media')->change();
        });
    }
}
