<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSundaySchoolTopics extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sunday_school_topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('year')->nullable(false);
            $table->string('category')->nullable(false);
            $table->string('topic')->nullable(false);
            $table->string('bible_text')->nullable(true);
            $table->text('aim')->nullable(true);
            $table->mediumText('introduction')->nullable(true);
            $table->longText('content')->nullable(false);
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
        Schema::dropIfExists('sunday_school_topics');
    }
}
