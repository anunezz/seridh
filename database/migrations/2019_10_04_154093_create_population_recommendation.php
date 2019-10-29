<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePopulationRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('population_recommendation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_population_id')->nullable();
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->timestamps();

            $table->foreign('cat_population_id')
                ->references('id')
                ->on('cat_populations');

            $table->foreign('recommendation_id')
                ->references('id')
                ->on('recommendations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('population_recommendation');
    }
}
