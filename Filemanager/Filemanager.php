<?php  namespace Modules\Filemanager\Filemanager;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Config\Repository as Configuration;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Modules\Filemanager\Entities\File as FileModel;
use League\Flysystem\File as Fly;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class FileManager extends FileForm
{

    private $image_quality = 100;

    private $todayDate;

    private $folderPermissions = 0777;

    /**
     * @var File
     */
    private $file;
    /**
     * @var Image
     */
    private $image;

    /**
     * @var Carbon
     */
    private $date;
    /**
     * @var Str
     */
    private $string;
    /**
     * @var FileManager
     */
    private $fileManager;
    /**
     * @var File
     */
    private $fileModel;

    /**
     * @param File|Fly $file
     * @param File $fileModel
     * @param ImageManager $image
     * @param Carbon $date
     * @param Str $string
     * @internal param FileManager $fileManager
     */
    public function __construct(Fly $file, FileModel $fileModel, ImageManager $image, Carbon $date, Str $string)
    {
        $this->file = $file;
        $this->image = $image;
        $this->date = $date;
        $this->string = $string;
        $this->fileModel = $fileModel;
    }


    public function make($file)
    {
        $this->file = $file;
        return $this;
    }

    public function save()
    {
        //dd($this->getImagePath() . $this->getImageFilename());
        $this->setToday();
        $this->setImageFilename();
        $this->fileModel->create($this->image);
        $this->image->save($this->getImagePath() . $this->getImageFilename(), $this->image_quality);
    }

    private function getImageFilename()
    {
        return $this->slug;
    }

    public function resize($options)
    {
        $image = $this->convertToImage($this->file);

        $image->resize($options['width'], $options['width'], function ($constraint) use ($options) {

            if (isset($options['ratio'])) {
                $constraint->aspectRatio();
            }

            if (isset($options['upsize'])) {
                $constraint->upsize();
            }
        });

        $this->image = $image;
        return $this;

    }

    private function convertToImage($file)
    {
        $this->image = $this->image->make($file);
        $this->image->name = $file->getClientOriginalName();
        $this->image->extension = $file->getClientOriginalExtension();
        return $this->image;
    }

    //2014/02/28
    private function getImagePath()
    {
        $dateFolder = $this->getFormatFolder();
        return $this->getDirectory($this->getFolderDir() . '/' . $dateFolder);
    }

    /**
     * Get files's folder directory
     * @return string
     */
    private function getFolderDir()
    {
        return public_path() . '/' . Config::get('filemanager::config.folder_dir');
    }

    private function setToday()
    {
        $this->todayDate = $this->date->now();
    }

    private function getFormatFolder()
    {
        $year = $this->todayDate->year;
        $month = $this->todayDate->month;
        $day = $this->todayDate->day;

        return $year . '/' . $month . '/' . $day . '/';
    }

    private function getTimestamp()
    {
        return $this->todayDate->toTimeString();
    }

    private function getNameWithoutExtension()
    {
        return explode($this->image->extension, $this->image->name)[0];
    }

    private function getDirectory($destinationPath)
    {

        File::exists($destinationPath) or File::makeDirectory($destinationPath, $this->folderPermissions, true, true);

        return $destinationPath;
    }

    private function setImageFilename()
    {
        $this->image->slug = $this->string->slug($this->getTimestamp() . ' ' . $this->getNameWithoutExtension()) . '.' . $this->image->extension;
    }


}