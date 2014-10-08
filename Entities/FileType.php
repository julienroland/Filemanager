<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;

class FileType extends Model
{
    protected $table = "files_types";

    public function file()
    {
        return $this->hasMany('Modules\Filemanager\Entities\File');
    }
}