<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThemesRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('themes_recommendation', function (Blueprint $table) {

            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->unsignedBigInteger('cat_topic_id')->nullable();
            $table->unsignedBigInteger('cat_subtopic_id')->nullable();


            $table->foreign('recommendation_id')
                ->references('id')
                ->on('recommendations');

            $table->foreign('cat_topic_id')
                ->references('id')
                ->on('cat_topics');

            $table->foreign('cat_subtopic_id')
                ->references('id')
                ->on('cat_subtopics');



        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('themes_recommendation');
    }
}
