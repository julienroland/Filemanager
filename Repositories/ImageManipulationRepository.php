<?php namespace Modules\Filemanager\Repositories;

interface ImageManipulationRepository
{
    public function resize($image, $options = array());
}