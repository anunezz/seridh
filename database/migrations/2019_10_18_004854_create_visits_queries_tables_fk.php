<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVisitsQueriesTablesFk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('queries_tables', function (Blueprint $table){
            $table->bigIncrements('id');
            $table->text('page');
            $table->timestamps();
            $table->foreign('id')->references('id')->on('visits_queries_tables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits_queries_tables_fk');
    }
}
