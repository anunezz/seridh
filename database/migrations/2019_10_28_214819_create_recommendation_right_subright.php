<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationRightSubright extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_right_subright', function (Blueprint $table) {
            $table->integer('recommendation_id');
            $table->integer('right_id');
            $table->integer('subrigth_id')->nullable();
            $table->integer('subcategory_subrights_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendation_right_subright');
    }
}
