<?php  namespace Modules\Filemanager\Repositories\Eloquent;


use Illuminate\Support\Str;
use Modules\Filemanager\Entities\FileVariantType;
use Modules\Filemanager\Repositories\ThumbControllerRepository;
use Modules\Filemanager\Thumb\Thumb;

class EloquentThumbControllerRepository implements ThumbControllerRepository
{
    /**
     * @var Str
     */
    private $string;
    /**
     * @var Thumb
     */
    private $thumb;

    public function __construct(Str $string, Thumb $thumb)
    {
        $this->string = $string;
        $this->thumb = $thumb;
    }

    public function create($request)
    {
        $request = array_filter_recursive($request);
        $variant = isset($request['variant']) ? json_encode($request['variant']) : null;
        $fileVariantType = FileVariantType::create(
            array(
                'name' => $request['title'],
                'slug' => $this->string->slug($request['tag']),
                'prefix' => '-' . $this->string->slug($request['tag']),
                'value' => $variant
            )
        );
        if (isset($request['modules'])) {
            $this->thumb->add($request['modules'], $fileVariantType);
        }
        return $fileVariantType;
    }

    public function all()
    {
        return FileVariantType::all();
    }

}
