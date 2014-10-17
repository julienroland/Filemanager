<?php  namespace Modules\Filemanager\Repositories\Eloquent;


use Modules\Filemanager\Entities\FileVariantType;
use Modules\Filemanager\Repositories\ThumbControllerRepository;

class EloquentThumbControllerRepository implements ThumbControllerRepository
{

    public function create($request)
    {

        $fileVariantType = FileVariantType::create(
            array(
                'name' => $request['title'],
                'prefix' => '-' . $request['tag'],
                'value' => json_encode($request['variant'])
            )
        );
        return $fileVariantType;
    }

    public function all()
    {
        return FileVariantType::all();
    }

}
