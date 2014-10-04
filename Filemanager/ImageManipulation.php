<?php  namespace Modules\Filemanager\Filemanager;

use Modules\Filemanager\Repositories\ImageManipulationRepository;

class ImageManipulation
{
    /**
     * @var
     */
    private $imageManipulation;

    /**
     * @var
     */
    public function __construct(ImageManipulationRepository $imageManipulation)
    {
        $this->imageManipulation = $imageManipulation;
    }

    public function resize($image, $options = array())
    {
        return $this->imageManipulation->resize($image, $options);
    }

}