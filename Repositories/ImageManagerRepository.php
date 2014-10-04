<?php namespace Modules\Filemanager\Repositories;

interface ImageManagerRepository
{
    public function make($file);

    public function save($file, $path, $quality );
}