<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\FileType;
use Modules\Filemanager\Repositories\FileTypeRepository;

class EloquentFileTypeRepository implements FileTypeRepository
{

    public function getIdByName($name)
    {
        return FileType::where('name', $name)->pluck('id');
    }
}