<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSubRightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_sub_rights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('rights_recommendations_id')->nullable();
            $table->string('name');
            $table->boolean('isActive')->default(1);
            $table->foreign('rights_recommendations_id')->references('id')->on('cat_rights_recommendations');
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
        Schema::dropIfExists('cat_sub_rights');
    }
}
