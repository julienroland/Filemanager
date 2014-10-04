<?php

namespace Modules\Filemanager\Facades;

use Illuminate\Support\Facades\Facade;

class TemplateFileUpload extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'templatefileupload';
    }
}
