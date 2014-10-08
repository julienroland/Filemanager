<?php namespace Modules\Filemanager\Repositories;

interface FileRepository
{

    public function create($file);

    public function all();

    public function update($id, $request);
}