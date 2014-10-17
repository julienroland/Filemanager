<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesInformationsTranslateTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files_informations_translations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('file_information_id')->unsigned();
            $table->foreign('file_information_id')->references('id')->on('files_informations');
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
        Schema::drop('files_informations_translations');
    }

}
