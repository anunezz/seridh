<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendigRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendig_recommendation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_attending_id')->nullable();
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->timestamps();

            $table->foreign('cat_attending_id')
                ->references('id')
                ->on('cat_attendings');

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
        Schema::dropIfExists('attendig_recommendation');
    }
}
