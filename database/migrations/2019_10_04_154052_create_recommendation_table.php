<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecommendationTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->longText('recommendation');

            $table->unsignedBigInteger('cat_entity_id')->nullable();
            $table->unsignedBigInteger('cat_gob_order_id')->nullable();
            $table->unsignedBigInteger('cat_gob_power_id')->nullable();
            $table->unsignedBigInteger('cat_attendig_id')->nullable();
            $table->unsignedBigInteger('cat_population_id')->nullable();
            $table->unsignedBigInteger('cat_solidarity_action_id')->nullable();
            $table->unsignedBigInteger('cat_topic_id')->nullable();
            $table->unsignedBigInteger('cat_subtopic_id')->nullable();
            $table->unsignedBigInteger('cat_ods_id')->nullable();
            $table->string('date')->nullable();
            $table->text('comments');
            $table->boolean('isActive')->default(1);
            $table->boolean('isPublished')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('cat_entity_id')
                ->references('id')
                ->on('cat_entities');

            $table->foreign('cat_gob_order_id')
                ->references('id')
                ->on('cat_gob_orders');

            $table->foreign('cat_gob_power_id')
                ->references('id')
                ->on('cat_gob_powers');

            $table->foreign('cat_attendig_id')
                ->references('id')
                ->on('cat_attendings');

            $table->foreign('cat_population_id')
                ->references('id')
                ->on('cat_populations');

            $table->foreign('cat_solidarity_action_id')
                ->references('id')
                ->on('cat_solidarity_actions');

            $table->foreign('cat_topic_id')
                ->references('id')
                ->on('cat_topics');

            $table->foreign('cat_subtopic_id')
                ->references('id')
                ->on('cat_subtopics');

            $table->foreign('cat_ods_id')
                ->references('id')
                ->on('cat_ods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendations');
    }
}
