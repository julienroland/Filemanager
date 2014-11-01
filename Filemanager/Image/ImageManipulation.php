<?php  namespace Modules\Filemanager\Filemanager\Image;

use Modules\Filemanager\Repositories\ImageManipulationRepository;

class ImageManipulation
{
    /**
     * @var
     */
    private $imageManipulation;
    private $manipulationPath = 'Modules\\Filemanager\\Image\\Manipulations\\';

    /**
     * @var
     */
    public function __construct(ImageManipulationRepository $imageManipulation)
    {
        $this->imageManipulation = $imageManipulation;
    }

    public function variant($variant)
    {
        $variantClass = $this->manipulationPath . ucfirst($variant);
        return new $variantClass;
    }

    public function variants($image, $variants)
    {
        if (is_array($variants)) {
            foreach ($variants as $variant => $variantValue) {
                $variantClass = $this->manipulationPath . ucfirst($variant);
                $image = new $variantClass($image, $variantValue);
            }
            return $image;

        } else {
            return $this->variant($variants);
        }
    }

    public function resize($image, $options = array())
    {
        return $this->imageManipulation->resize($image, $options);
    }

}
