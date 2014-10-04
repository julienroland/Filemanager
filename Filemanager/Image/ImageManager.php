<?php namespace Modules\Filemanager\Filemanager\Image;

use Intervention\Image\ImageManager;

class ImageManager
{
    /**
     * @var ImageManager
     */
    private $image;

    public function __construct(ImageManager $image){

        $this->image = $image;
    }
}