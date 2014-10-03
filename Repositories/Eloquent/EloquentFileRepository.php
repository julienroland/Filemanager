<?php  namespace Modules\Filemanager\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Repositories\FileRepository;

class EloquentFileRepository extends Model implements FileRepository
{
    public function createFile($file)
    {
        dd($file);
        
    }
}