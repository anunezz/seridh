<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecommendationDocs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recommendation_docs', function (Blueprint $table) {
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();


            $table->foreign('recommendation_id')
                ->references('id')
                ->on('recommendations');

            $table->foreign('document_id')
                ->references('id')
                ->on('document_recommendations');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recommendation_docs');
    }
}
