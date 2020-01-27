<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicRecomendationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('public_recomendation', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('seridh')->nullable();
            $table->boolean('activeSeridh')->default(1);
            $table->longText('undersecretary')->nullable();
            $table->unsignedBigInteger('path_undersecretary')->nullable();
            $table->boolean('activeUndersecretary')->default(1);
            $table->longText('dgdhd')->nullable();
            $table->unsignedBigInteger('path_dgdhd')->nullable();
            $table->boolean('activeDgdhd')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('public_recomendation');
    }
}
