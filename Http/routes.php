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
                    'as'=>'filemanager.library',
                    'uses' => 'FileController@outputLibrary'
                ]);

                post('ajax/upload',
                    [
                        'as' => Config::get('filemanager::config.module_name') . '.ajax.upload',
                        'uses' => 'FilemanagerController@upload'
                    ]);

                get('ajax/getTranslation', [
                    'uses' => 'TranslationController@all'
                ]);

                get('ajax/folder/create', [
                    'uses' => 'DirectoryController@create'
                ]);



                get('ajax/folder/update/{id}', [
                    'uses' => 'DirectoryController@update'
                ]);

                get('ajax/file/update/{id}', [
                    'uses' => 'FileController@update'
                ]);

                get('ajax/file/{file_id}/append/folder/{folder_id}', [
                    'uses' => 'FileController@append'
                ]);

                /* End uploads */
            });
    });