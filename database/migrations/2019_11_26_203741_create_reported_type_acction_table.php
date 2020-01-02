<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportedTypeAcctionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reported_type_acction', function (Blueprint $table) {
            $table->unsignedBigInteger('reported_id')->nullable();
            $table->unsignedBigInteger('type_action_id')->nullable();


            $table->foreign('reported_id')
                ->references('id')
                ->on('reported_actions');

            $table->foreign('type_action_id')
                ->references('id')
                ->on('cat_solidarity_actions');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reported_type_acction');
    }
}
