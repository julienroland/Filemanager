<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;

class FileDirectory extends Model
{
    protected $table = "files_directories";

    protected $fillable = ['name'];

    public function file()
    {
        return $this->belongsToMany('Modules\Filemanager\Entities\File', 'files_files_directories');
    }
}