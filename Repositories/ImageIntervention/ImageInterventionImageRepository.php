<?php  namespace Modules\Filemanager\Repositories\ImageIntervention;

use Intervention\Image\ImageManager as ImageIntervention;
use Modules\Filemanager\Repositories\ImageRepository;

class ImageInterventionImageRepository implements ImageRepository
{
    /**
     * @var ImageIntervention
     */
    private $image;

    /**
     * @param ImageIntervention $image
     */
    public function __construct(ImageIntervention $image)
    {
        $this->image = $image;
    }

    public function make($file)
    {
        return $this->image->make($file);
    }

    public function save($file, $path, $quality, $provider = null)
    {

        return $file->save($path, $quality);

    }
}
