<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesFilesDirectoriesTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('files_files_directories', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('file_id')->unsigned();
            $table->foreign('file_id')->references('id')->on('files');

            $table->integer('file_directory_id')->unsigned()->nullable();
            $table->foreign('file_directory_id')->references('id')->on('files_directories')->nullable();

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
