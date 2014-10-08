<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\FileAccessType;
use Modules\Filemanager\Repositories\FileAccessTypeRepository;

class EloquentFileAccessTypeRepository implements FileAccessTypeRepository
{
    public function getIdByName($name)
    {
        return FileAccessType::where('name', $name)->pluck('id');
    }


}