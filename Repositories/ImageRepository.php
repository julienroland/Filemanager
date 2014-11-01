<?php namespace Modules\Filemanager\Repositories;

interface ImageRepository
{
    public function make($file);

    public function save($file, $path, $quality, $provider = null);
}
