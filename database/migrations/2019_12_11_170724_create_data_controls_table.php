<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataControlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_controls', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->unsignedBigInteger('typeIndicator')->nullable();
            $table->unsignedBigInteger('levelAttention')->nullable();
            $table->unsignedBigInteger('attentionClassification')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('data_controls');
    }
}
