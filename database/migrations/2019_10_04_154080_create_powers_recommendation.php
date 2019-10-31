<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePowersRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('powers_recommendation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_gob_power_id')->nullable();
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->timestamps();

            $table->foreign('cat_gob_power_id')
                ->references('id')
                ->on('cat_gob_powers');

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
        Schema::dropIfExists('powers_recommendation');
    }
}
