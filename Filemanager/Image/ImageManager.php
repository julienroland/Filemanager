<?php namespace Modules\Filemanager\Filemanager\Image;

use Modules\Filemanager\Filemanager\FileProvider;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
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
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param ImageIntervention $image
     * @param ImageManipulation $imageManipulation
     */
    public function __construct(
        ImageManipulation $imageManipulation,
        ImageManagerRepository $image,
        Filesystem $filesystem
    ) {
        $this->image = $image;
        $this->imageManipulation = $imageManipulation;
        $this->filesystem = $filesystem;
    }

    public function make($file)
    {
        return $this->image->make($file);
    }

    public function save($file, $path, $type, $provider = null)
    {
        if ($this->isDirectory($type)) {
            if (!is_null($provider)) {
                $image = $this->image->save($file, $this->getFileFullPath($file),
                    $this->image_quality, $provider);

                $this->filesystem->disk($provider)->put($path['pathfilename'], $image->encoded);
                dd('Dropbox saved');
            } else {
                return $this->image->save($file, $this->getFileFullPath($file), $this->image_quality, $provider);
            }

        } elseif ($this->isDatabase($type)) {

            dd('save to db');

        }
    }

    public function resize($file, $options)
    {
        return $this->imageManipulation->resize($file, $options);
    }

    private function getFilePathWithProvider($path, $provider)
    {
        $pathExplode = explode($path['path'], $path['pathfilename']);
        return $path['path'] . $provider . '/' . $pathExplode[1];
    }

}