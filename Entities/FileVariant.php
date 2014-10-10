<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;

class FileVariant extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'url',
        'width',
        'height',
        'size',
        'file_id',
    ];

    protected $table = "files_variants";
}