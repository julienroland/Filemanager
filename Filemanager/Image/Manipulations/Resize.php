<?php  namespace Modules\Filemanager\Filemanager\Image\Manipulations;

class Resize extends AbstractManipulation
{
    private $image;
    /**
     * @var ImageManipulationRepository
     */
    private $imageManipulation;
    /**
     * @var array
     */
    private $options = array();

    public function __construct($image, $options = array())
    {
        $this->image = $image;
        $this->options = $options;
    }

    public function manipulate(ImageManipulationRepository $imageManipulation)
    {
        $imageManipulation->resize($this->image, $this->options);
    }

    public function execute(ImageManipulationRepository $imageManipulation, $image)
    {
        return $imageManipulation->resize($this->image, $this->options);
    }
}
