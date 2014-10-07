<?php

Route::group(['prefix' => LaravelLocalization::setLocale(), 'before' => 'LaravelLocalizationRedirectFilter'],
    function () {

        Route::group(
            [
                'prefix' => 'filemanager',
                'namespace' => 'Modules\Filemanager\Http\Controllers'
            ], function () {

                get('/', function () {
                    return view('filemanager::test');
                });

                post('/test', ['as' => 'test', 'uses' => 'TestController@create']);

                /* Uploads */
                post('upload',
                    [
                        'as' => Config::get('filemanager::config.module_name') . '.upload',
                        'uses' => 'FileManagerController@upload'
                    ]);

                get('library', [
                    'uses' => 'FileController@outputLibrary'
                ]);

                post('ajax/upload',
                    [
                        'as' => Config::get('filemanager::config.module_name') . '.ajax.upload',
                        'uses' => 'FilemanagerController@upload'
                    ]);
                /* End uploads */
            });
    });