<?php  namespace Modules\Filemanager\Filemanager;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use League\Flysystem\File as Fly;


class FileManager
{

    private $image_quality = 100;

    private $todayDate;

    private $folderPermissions = 0777;

    /**
     * @var File
     */
    protected $file;
    /**
     * @var Image
     */
    public $image;

    /**
     * @var Carbon
     */
    protected $date;
    /**
     * @var Str
     */
    private $string;
    /**
     * @var FileManager
     */
    protected $fileManager;
    /**
     * @var File
     */
    protected $fileModel;
    /**
     * @var ImageManipulation
     */
    private $imageManipulation;

    /**
     * @param File|Fly $file
     * @param ImageManager $image
     * @param Carbon $date
     * @param Str $string
     * @param ImageManipulation $imageManipulation
     * @internal param File $fileModel
     * @internal param FileManager $fileManager
     */
    public function __construct(
        Fly $file,
        ImageManager $image,
        Carbon $date,
        Str $string,
        ImageManipulation $imageManipulation
    ) {
        $this->file = $file;
        $this->image = $image;
        $this->date = $date;
        $this->string = $string;
        $this->imageManipulation = $imageManipulation;
    }


    public function make($file)
    {
        $this->file = $file;
        return $this;
    }

    public function save()
    {
        $this->setToday();
        $this->setSlug();
        $imageUploaded = $this->image->save($this->getImagePath() . $this->getImageFilename(), $this->image_quality);
        if ($imageUploaded) {
            dd('Uploaded');
        }
    }

    private function getImageFilename()
    {
        return $this->image->slug;
    }


    protected function convertToImage($file)
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

    private function setSlug()
    {
        $this->image->slug = $this->string->slug($this->getTimestamp() . ' ' . $this->getNameWithoutExtension()) . '.' . $this->image->extension;
    }

    protected function setImage($image)
    {
        $this->image = $image;

    }

    public function resize($options)
    {
        $this->isImage();
        $this->setImage($this->imageManipulation->resize($this->image, $options));

        return $this;
    }

    private function isImage()
    {
        $image = $this->convertToImage($this->file);
        $this->setImage($image);
    }

    private function setAndGetImage($image)
    {
        $this->setImage($image);
        return $this->getImage();
    }

    private function getImage()
    {
        return $this->image;
    }


}