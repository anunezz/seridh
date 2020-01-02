<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatGoalsOdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_goals_ods', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('ods_id')->nullable();
            $table->longText('name');
            $table->string('acronym')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('ods_id')
                ->references('id')
                ->on('cat_ods');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_goals_ods');
    }
}
