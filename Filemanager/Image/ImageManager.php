<?php namespace Modules\Filemanager\Filemanager\Image;

use Intervention\Image\ImageManager as ImageIntervention;
use Modules\Filemanager\Filemanager\FileProvider;

class ImageManager extends FileProvider
{
    private $image_quality = 100;
    /**
     * @var ImageManager
     */
    private $image;

    public function __construct(ImageIntervention $image)
    {
        $this->image = $image;
    }

    public function make($file)
    {
        return $this->image->make($file);
    }

    public function save($file, $type)
    {
        if ($this->isDirectory($type)) {

            return $file->save($this->getFileFullPath($file), $this->image_quality);

        } elseif ($this->isDatabase($type)) {

            dd('save to db');

        }
    }


}