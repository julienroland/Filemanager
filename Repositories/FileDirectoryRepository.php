<?php namespace Modules\Filemanager\Repositories;


interface FileDirectoryRepository
{

    public function find($id);

    public function get($id = null);

    public function create($name = null);

    public function update($id, $request);

}