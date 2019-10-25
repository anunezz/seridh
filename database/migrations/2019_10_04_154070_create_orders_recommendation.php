<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersRecommendation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_recommendation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cat_gob_order_id')->nullable();
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->timestamps();

            $table->foreign('cat_gob_order_id')
                ->references('id')
                ->on('cat_gob_orders');

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
        Schema::dropIfExists('orders_recommendation');
    }
}
