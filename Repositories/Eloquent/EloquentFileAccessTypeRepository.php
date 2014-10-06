<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileAccessType;
use Modules\Filemanager\Repositories\FileAccessTypeRepository;

class EloquentFileAccessTypeRepository extends Model implements FileAccessTypeRepository
{
    /**
     * @var FileAccessType
     */
    private $fileAccessType;

    public function __construct(FileAccessType $fileAccessType)
    {
        $this->fileAccessType = $fileAccessType;
    }

    public function getIdByName($name)
    {

        return $this->fileAccessType->where('name', 'http')->pluck('id');
    }


}