<?php namespace Modules\Filemanager\Repositories;

interface ThumbRepository
{
    public function find($module_name, $thumb_name);

    public function get();

    public function add($modulesList, $fileVariantType);

    public function create();

    public function availables();
}
