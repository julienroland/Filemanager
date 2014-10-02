<?php namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\FilePath;

abstract class AbstractEloquentRepository
{

    public function getFilePath()
    {
        return FilePath::first();
    }
}