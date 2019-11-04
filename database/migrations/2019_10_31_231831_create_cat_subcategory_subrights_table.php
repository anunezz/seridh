<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatSubcategorySubrightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_subcategory_subrights', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_rights_id')->nullable();
            $table->string('name');
            $table->boolean('isActive')->default(1);
            $table->foreign('sub_rights_id')->references('id')->on('cat_sub_rights');
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
        Schema::dropIfExists('cat_subcategory_subrights');
    }
}
