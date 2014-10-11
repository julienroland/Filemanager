<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;

class FileVariant extends Model
{
    protected $fillable = [
        'name',
        'group',
        'slug',
        'url',
        'width',
        'height',
        'size',
        'file_id',
    ];

    public function scopeIcon($query)
    {
        $query->where('group', 'icon');
    }

    protected $table = "files_variants";
}