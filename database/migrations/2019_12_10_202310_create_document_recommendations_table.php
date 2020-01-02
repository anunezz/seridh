<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentRecommendationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('document_recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->longText('folio')->nullable();
            $table->string('title');
            $table->unsignedBigInteger('cat_entity_id')->nullable();
            $table->string('date')->nullable();
            $table->unsignedBigInteger('document_id')->nullable();
            $table->boolean('isActive')->default(1);
            $table->timestamps();

            $table->foreign('cat_entity_id')
                ->references('id')
                ->on('cat_entities');

            $table->foreign('document_id')
                ->references('id')
                ->on('documents');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('document_recommendations');
    }
}
