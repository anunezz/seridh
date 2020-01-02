<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedAuthorityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_authority', function (Blueprint $table) {
            $table->unsignedBigInteger('reported_id')->nullable();
            $table->unsignedBigInteger('authority_id')->nullable();


            $table->foreign('reported_id')
                ->references('id')
                ->on('reported_actions');

            $table->foreign('authority_id')
                ->references('id')
                ->on('cat_attendings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_authority');
    }
}
