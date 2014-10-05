<?php  namespace Modules\Filemanager\Filemanager;

use Carbon\Carbon;
//use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\Factory as Filesystem;
use Modules\Filemanager\Filemanager\Image\ImageManager;
use Modules\Filemanager\Http\Requests\UploadRequest;


/**
 * @property mixed setFileFullPath
 */
class FileManager
{
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
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @param File|Fly $file
     * @param ImageManager $image
     * @param Carbon $date
     * @param Str $string
     * @param Filesystem $filesystem
     * @internal param ImageManipulation $imageManipulation
     * @internal param File $fileModel
     * @internal param FileManager $fileManager
     */
    public function __construct(
        Filesystem $filesystem,
        ImageManager $image,
        Carbon $date,
        Str $string,
        Filesystem $filesystem
    ) {
        $this->filesystem = $filesystem;
        $this->image = $image;
        $this->date = $date;
        $this->string = $string;
    }


    public function make($fileOrRequest, $type = null)
    {
        if (!$this->isRequest($fileOrRequest)) {
            $this->setFile($fileOrRequest);
            $this->setFileType($type);
        }
        $this->changeToTypeFile();
        return $this;
    }

    public function save()
    {
        $this->setToday();
        $this->setSlug();
        $this->setFileFullPath();
        $fileUploaded = $this->fileSaveInFolder();
        //$filedatabased = $this->fileSaveToDatabase();

        if ($fileUploaded) {
            echo 'Uploaded';
        }
        //if ($filedatabased) {
        //  echo 'Insert';
        //}
    }

    public function resize($options)
    {
        $this->setImage($this->image->resize($this->file, $options));
        return $this;
    }

    protected function setImage($image)
    {
        $this->file = $image;
    }


    protected function convertToImage($file = null)
    {
        if (is_null($file)) {
            $file = $this->getFile();
        }

        $this->file = $this->image->make($file);
        $this->file->name = $file->getClientOriginalName();
        $this->file->extension = $file->getClientOriginalExtension();

        return $this->file;
    }


    private function getFileFilename()
    {
        return $this->file->slug;
    }

    //2014/02/28
    private function getFilePath()
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
        return explode($this->file->extension, $this->file->name)[0];
    }

    private function getDirectory($destinationPath)
    {
        $this->filesystem->disk('dropbox')->exists($destinationPath) or $this->filesystem->disk('local')->makeDirectory($destinationPath, $this->folderPermissions, true, true);

        return $destinationPath;
    }

    private function setSlug()
    {
        $this->file->slug = $this->string->slug($this->getTimestamp() . ' ' . $this->getNameWithoutExtension()) . '.' . $this->file->extension;
    }


    private function getFile()
    {
        return $this->file;
    }

    private function isRequest($fileOrRequest)
    {
        if ($fileOrRequest instanceof UploadRequest) {

            if ($fileOrRequest->hasFile(Config::get('filemanager::config.file_name'))) {

                $this->setFile($fileOrRequest->file(Config::get('filemanager::config.file_name')));

                if ($fileOrRequest->has(Config::get('filemanager::config.hidden_field_name'))) {

                    $this->setFileType($fileOrRequest->get(Config::get('filemanager::config.hidden_field_name')));
                }

                return true;
            }

            return false;
        }

        return false;
    }

    private function setFile($file)
    {

        $this->file = $file;
    }

    private function setFileType($type = null)
    {
        $this->type = !is_null($type) ? $type : 'file';
    }

    private function changeToTypeFile()
    {
        switch ($this->type) {
            case 'file':
                return $this->detectFileType();
                break;
            case 'image':
                return $this->convertToImage();
                break;
        }
    }

    private function detectFileType()
    {
        //Todo: new class to check based on controller
    }


    private function fileSaveInFolder()
    {
        switch ($this->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, 'directory');
                break;
        }
    }


    private function fileSaveToDatabase()
    {
        switch ($this->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, 'database');
                break;
        }
    }

    private function setFileFullPath()
    {
        $this->file->fullPath = $this->getFilePath() . $this->getFileFilename();
    }


}