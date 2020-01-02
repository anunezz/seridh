<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOdsRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ods_recommendation', function (Blueprint $table) {
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->unsignedBigInteger('ods_id')->nullable();
            $table->unsignedBigInteger('goals_ods_id')->nullable();

            $table->foreign('recommendation_id')
                ->references('id')
                ->on('recommendations');

            $table->foreign('ods_id')
                ->references('id')
                ->on('cat_ods');

            $table->foreign('goals_ods_id')
                ->references('id')
                ->on('cat_goals_ods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ods_recommendation');
    }
}
