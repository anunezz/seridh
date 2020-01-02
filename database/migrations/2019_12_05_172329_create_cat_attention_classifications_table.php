<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCatAttentionClassificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cat_attention_classifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('level_attentions_id')->nullable();
            $table->string('name');
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('level_attentions_id')
                ->references('id')
                ->on('cat_level_attentions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cat_attention_classifications');
    }
}
