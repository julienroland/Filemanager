<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('group')->nullable();
            $table->string('slug');
            $table->string('extension');
            $table->string('mime');
            $table->string('url');
            $table->string('virtual_url')->unique();
            $table->integer('width');
            $table->integer('height');
            $table->integer('size')->nullable();
            $table->string('timestamp');
            $table->string('external_url')->nullable();

            $table->integer('file_variant_id')->unsigned()->nullable();
            $table->foreign('file_variant_id')->references('id')->on('files_variants');

            $table->integer('file_access_type_id')->unsigned()->nullable();
            $table->foreign('file_access_type_id')->references('id')->on('files_access_types');

            $table->integer('user_id')->unsigned()->nullable();
            $table->foreign('user_id')->references('id')->on('users');

            $table->integer('file_type_id')->unsigned()->nullable();
            $table->foreign('file_type_id')->references('id')->on('files_types');

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
        Schema::drop('files');
    }

}
