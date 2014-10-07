<?php namespace Modules\Filemanager\Repositories;

interface FileRepository
{

    public function createFile($file);

    public function getFiles();
}