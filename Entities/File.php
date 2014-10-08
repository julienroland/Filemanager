<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Repositories\FileRepository;

class File extends Model
{
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

}