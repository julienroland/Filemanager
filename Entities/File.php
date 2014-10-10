<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Entities\FileType;

class File extends Model
{
    protected $table = "files";

    protected $fillable = [
        'name',
        'group',
        'slug',
        'extension',
        'mime',
        'url',
        'virtual_url',
        'width',
        'height',
        'size',
        'timestamp',
        'external_url',
        'file_variant_id',
        'file_access_type_id',
        'user_id',
        'file_type_id',
    ];

    public function fileType()
    {
        return $this->belongsTo('Modules\Filemanager\Entities\FileType');
    }

    public function fileDirectory()
    {
        return $this->belongsToMany('Modules\Filemanager\Entities\FileDirectory', 'files_files_directories');
    }

    public function fileVariant()
    {
        return $this->hasMany('Modules\Filemanager\Entities\FileVariant');
    }

}