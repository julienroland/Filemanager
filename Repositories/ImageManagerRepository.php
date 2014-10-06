<?php namespace Modules\Filemanager\Repositories;

// Modules\Filemanager\Filemanager\Image\ImageManipulation

interface ImageManagerRepository
{
    public function make($file);

    public function save($file, $path, $quality, $provider = null);
}