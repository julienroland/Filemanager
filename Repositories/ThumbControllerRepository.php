<?php namespace Modules\Filemanager\Repositories;

interface ThumbControllerRepository
{
    public function create($request);

    public function all();
}
