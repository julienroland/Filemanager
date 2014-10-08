<?php namespace Modules\Filemanager\Repositories;


interface FileDirectoryRepository
{

    public function all();

    public function create($name = null);

    public function update($id, $request);

}