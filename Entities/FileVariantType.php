<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;

class  FileVariantType extends Model
{
    protected $table = "files_variants_types";
    protected $fillable = array('name', 'prefix', 'slug', 'value');

}
