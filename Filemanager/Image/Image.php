<?php namespace Modules\Filemanager\Filemanager\Image;

use Modules\Filemanager\Filemanager\DatabaseDriver\DatabaseDriver;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Modules\Filemanager\Repositories\ImageManagerRepository;
use Modules\Filemanager\Repositories\ImageRepository;

class Image
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
     * @var AbstractImageDriver
     */
    private $driver;

    /**
     * @param AbstractImageDriver $driver
     * @param ImageManipulation $imageManipulation
     * @param ImageIntervention|ImageManagerRepository $image
     * @param Filesystem $filesystem
     * @param DatabaseDriver $database
     */
    public function __construct(
        ImageManipulation $imageManipulation,
        ImageRepository $image,
        Filesystem $filesystem,
        DatabaseDriver $database
    ) {
        $this->image = $image;
        $this->imageManipulation = $imageManipulation;
        $this->filesystem = $filesystem;
        $this->database = $database;
    }

    public function __call($name, $options)
    {
        dd($name.' '.$options);
        $command = $this->driver->executeVariant($this, $name, $options);
        return $command->hasOutput() ? $command->getOutput() : $this;
    }

    public function make($file)
    {
        return $this->image->make($file);
    }

    public function save($file, $path, $type, $variant, $provider = null)
    {
        if ($this->isDirectory($type)) {
            return $this->directorySave($file, $path, $provider);
        }
        if ($this->isDatabase($type)) {
            return $this->databaseSave($file, $path, $variant, $provider);
        }

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

  /*  public function resize($file, $options)
    {
        return $this->imageManipulation->resize($file, $options);
    }*/

    private function getFilePathWithProvider($path, $provider)
    {
        $pathExplode = explode($path['path'], $path['pathfilename']);
        return $path['path'] . $provider . '/' . $pathExplode[1];
    }

    private function saveImageFolder($file, $provider)
    {
        return $this->image->save($file, $this->getFileFullPath($file),
            $this->image_quality, $provider);
    }

    private function saveImageProvider($pathfilename, $provider, $encoded)
    {
        return $this->filesystem->disk($provider)->put($pathfilename, $encoded);
    }

    private function saveImageDatabase($file, $path, $variant, $provider)
    {
        return $this->database->create($file, $path, $variant, $provider);
    }

    private function saveProviderImageDatabase($file, $path, $variant, $provider)
    {
        $this->database->create($file, $path, $variant, $provider);
    }

    private function directorySave($file, $path, $provider = null)
    {
        /* Provider */
        if (!is_null($provider)) {
            try {
                $image = $this->saveImageFolder($file, $provider);
                $this->saveImageProvider($path['pathfilename'], $provider, $image->encoded);
            } catch (Exception $e) {
                dd($e);
            }
        } else {
            $fileUploaded = $this->saveImageFolder($file, $provider);
        }
    }

    private function databaseSave($file, $path, $variant, $provider = null)
    {
        if (!is_null($provider)) {
            //$this->saveProviderImageDatabase($file, $path, $provider);

        } else {

            return $this->saveImageDatabase($file, $path, $variant, $provider);
        }
    }

}
