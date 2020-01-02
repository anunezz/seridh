<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedPopulationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_population', function (Blueprint $table) {
            $table->unsignedBigInteger('reported_id')->nullable();
            $table->unsignedBigInteger('population_id')->nullable();


            $table->foreign('reported_id')
                ->references('id')
                ->on('reported_actions');

            $table->foreign('population_id')
                ->references('id')
                ->on('cat_populations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_population');
    }
}
