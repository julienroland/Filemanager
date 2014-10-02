<?php

Route::group(['prefix' => 'filemanager', 'namespace' => 'Modules\Filemanager\Http\Controllers'], function () {
    Route::get('/', function(){
        return view('filemanager::')
    });
});