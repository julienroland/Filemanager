<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\FileDirectory;
use Modules\Filemanager\Repositories\FileDirectoryRepository;

class EloquentFileDirectoryRepository implements FileDirectoryRepository
{
    public function create($data = array())
    {
        $folder = FileDirectory::create($data);

        return $folder;
    }
}