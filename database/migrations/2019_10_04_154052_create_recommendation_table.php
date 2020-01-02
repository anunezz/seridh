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
            $table->unsignedBigInteger('validity')->nullable();
            $table->unsignedBigInteger('directed')->nullable();
            $table->unsignedBigInteger('cat_entity_id')->nullable();
            $table->string('date')->nullable(); //String inecesario, se trata de una fecha $table->year('date');
            $table->text('comments');
            $table->longText('invoice')->nullable();
            $table->boolean('isActive')->default(1);
            $table->boolean('isPublished')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

            $table->foreign('cat_entity_id')
                ->references('id')
                ->on('cat_entities');
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
