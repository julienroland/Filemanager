<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Modules\Filemanager\Entities\File;
use Modules\Filemanager\Repositories\FileRepository;

class EloquentFileRepository implements FileRepository
{

    public function create($file)
    {
        $file = File::create($file);

        return $file;

    }

    public function all()
    {
        $files = File::all();

        return $files;
    }
}