<?php  namespace Modules\Filemanager\Filemanager\Image\Manipulations;

abstract class AbstractManipulation
{
    /**
     * @var array
     */
    private $options;

    public function __construct($options = array()){
        $this->options = $options;
    }
    abstract public function execute(ImageManipulationRepository $imageManipulation, $image);
}
