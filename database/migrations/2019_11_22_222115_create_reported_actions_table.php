<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedActionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_actions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('invoice')->nullable();
            $table->unsignedBigInteger('recommendation_id')->nullable();
            $table->string('date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('isActive')->default(1);
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
        Schema::dropIfExists('reported_actions');
    }
}
