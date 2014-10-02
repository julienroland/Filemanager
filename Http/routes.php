<?php

Route::group(['prefix' => 'filemanager', 'namespace' => 'Modules\Filemanager\Http\Controllers'], function()
{
	Route::get('/', 'FilemanagerController@index');
});