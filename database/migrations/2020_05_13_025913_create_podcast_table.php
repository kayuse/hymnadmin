<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcasts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('topic_id');
            $table->string('media');
            $table->timestamps();
        });
        Schema::create('podcast_comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('podcast_id');
            $table->string('media');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('podcasts');
        Schema::dropIfExists('podcast_comments');
    }
}
