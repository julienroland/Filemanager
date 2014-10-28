<?php  namespace Modules\Filemanager\Thumb;

use Modules\Filemanager\Filemanager\File\Filesystem;
use Modules\Filemanager\Repositories\ThumbRepository;

class Thumb
{
    /**
     * @var Filesystem
     */
    private $file;
    /**
     * @var FileThumbRepository
     */
    private $thumb;

    public function __construct(Filesystem $file, ThumbRepository $thumb)
    {
        $this->file = $file;
        $this->thumb = $thumb;
    }

    public function find($module_name, $thumb_name)
    {
        return $this->thumb->find($module_name, $thumb_name);
    }

    public function get()
    {
        return $this->thumb->get();
    }

    public function add($modulesList, $fileVariantType)
    {
        return $this->thumb->add($modulesList, $fileVariantType);
    }

    public function create()
    {
        return $this->thumb->create();
    }

    public function availables()
    {
        return $this->thumb->availables();
    }

}
