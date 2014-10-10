<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\FileVariant;
use Modules\Filemanager\Repositories\FileVariantRepository;

class EloquentFileVariantRepository implements FileVariantRepository
{

    public function create($data)
    {
        $fileVariant = FileVariant::create($data);
        return $fileVariant;
    }
}