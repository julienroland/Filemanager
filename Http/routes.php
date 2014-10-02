<?php

Route::group(['prefix' => 'filemanager', 'namespace' => 'Modules\Filemanager\Http\Controllers'], function () {
    Route::get('/', function () {
        return view('filemanager::test');
    });

    /* Uploads */
    Route::post('upload',
        [
            'as' => Config::get('filemanager::config.module_name') . '.upload',
            'uses' => 'FileManagerController@upload'
        ]);

    Route::get('ajax/upload',
        [
            'as' => Config::get('filemanager::config.module_name') . '.ajax.upload',
            'uses' => 'FileManagerController@upload'
        ]);
    /* End uploads */
});