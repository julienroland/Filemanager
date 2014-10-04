<?php namespace Modules\Filemanager\Filemanager\Image;

use Modules\Filemanager\Filemanager\FileProvider;
use Modules\Filemanager\Repositories\ImageManagerRepository;

class ImageManager extends FileProvider
{
    private $image_quality = 100;
    /**
     * @var ImageManager
     */
    private $image;
    /**
     * @var ImageManipulation
     */
    private $imageManipulation;

    /**
     * @param ImageIntervention $image
     * @param ImageManipulation $imageManipulation
     */
    public function __construct(
        ImageManipulation $imageManipulation,
        ImageManagerRepository $image
    ) {
        $this->image = $image;
        $this->imageManipulation = $imageManipulation;
    }

    public function make($file)
    {
        return $this->image->make($file);
    }

    public function save($file, $type)
    {

        if ($this->isDirectory($type)) {

            return $this->image->save($file, $this->getFileFullPath($file), $this->image_quality);

        } elseif ($this->isDatabase($type)) {

            dd('save to db');

        }
    }

    public function resize($file, $options)
    {
        return $this->imageManipulation->resize($file, $options);
    }

}