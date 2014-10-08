<?php namespace Modules\Filemanager\Repositories;

interface FileRepository
{

    public function create($file);

    public function all();
}