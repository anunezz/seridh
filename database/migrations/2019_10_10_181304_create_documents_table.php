<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->longText('invoice')->nullable();
            $table->text('fileName');
            $table->text('fileNameHash');
            $table->boolean('isActive')->default(0);
            $table->integer('isType')->default(0);
            $table->boolean('isPublished')->default(0);
            $table->bigInteger('downloadCount')->default(0);
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
