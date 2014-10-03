<?php

namespace Modules\Filemanager\Facades;

use Illuminate\Support\Facades\Facade;

class Filemanager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filemanager';
    }
}
