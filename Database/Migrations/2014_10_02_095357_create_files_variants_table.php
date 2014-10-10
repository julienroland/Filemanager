<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesVariantsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_variants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('group')->nullable();
            $table->string('url');
            $table->string('slug');
            $table->integer('width');
            $table->integer('height');
            $table->integer('size')->nullable();
            $table->integer('file_id')->unsigned()->nullable();
            $table->foreign('file_id')->references('id')->on('files');
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
        Schema::drop('files_variants');
    }

}
