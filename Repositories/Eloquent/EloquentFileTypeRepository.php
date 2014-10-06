<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Repositories\FileTypeRepository;

class EloquentFileTypeRepository extends Model implements FileTypeRepository
{

    public function getIdByName($name)
    {
        return $this->where('name', $type)->pluck('id');

    }
}