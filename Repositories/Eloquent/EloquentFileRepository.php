<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Repositories\FileRepository;

class EloquentFileRepository extends Model implements FileRepository
{
    protected $table = "files";


    public function createFile($file)
    {
        dd($file);

    }

    public function getFiles()
    {
        $files = EloquentFileRepository::all();

        return $files;
    }
}