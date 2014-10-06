<?php  namespace Modules\Filemanager\Filemanager;

use Carbon\Carbon;
use Illuminate\Filesystem\Filesystem as Filesystem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Contracts\Filesystem\Factory as Flysystem;
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
        Flysystem $flysystem,
        Filesystem $filesystem,
        ImageManager $image,
        Carbon $date,
        Str $string
    ) {
        $this->flysystem = $flysystem;
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
        $this->setDateFolder($dateFolder);
        return $this->getDirectory($this->getFolderDir() . '/' . $dateFolder, $dateFolder);
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

    private function getDirectory($destinationPath, $provider_path)
    {
        if (isset($this->provider)) {
            $this->flysystem->disk($this->getProvider())->exists($provider_path) or $this->flysystem->disk($this->getProvider())->makeDirectory($provider_path,
                $this->folderPermissions, true, true);

            $this->filesystem->exists($destinationPath . $this->getProvider()) or $this->filesystem->makeDirectory($destinationPath . $this->getProvider(),
                $this->folderPermissions, true, true);

        } else {
            $this->filesystem->exists($destinationPath) or $this->filesystem->makeDirectory($destinationPath,
                $this->folderPermissions, true, true);
        }
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
        $this->hasAProvider();

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
                return $this->image->save($this->file, $this->getPath(), 'directory', $this->provider);
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

    private function getPath()
    {
        return [
            'path' => $this->getFormatFolder(),
            'pathfilename' => $this->getFormatFolder() . $this->getFileFilename(),
            'fullPath' => $this->getFileFullPath(),
        ];
    }

    private function getFileFullPath()
    {
        return $this->file->fullPath;
    }

    private function setFileFullPath()
    {
        $provider = isset($this->provider) ? $this->provider.'/' :'';
        $fullpath = $this->getFilePath() . $provider .$this->getFileFilename();
        $this->file->fullPath = $fullpath;
    }

    private function setFileFolders()
    {
        $this->file->folders = $this->getFileFolders();
    }


    private function hasAProvider()
    {
        $types = explode('::', $this->type);

        if (isset($types[1])) {
            $this->setFileType($types[1]);
            $this->setProvider($types[0]);
        }
    }

    private function setProvider($provider)
    {
        $this->provider = $provider;
    }

    private function getProvider()
    {
        return $this->provider;
    }

    private function setDateFolder($dateFolder)
    {
        $this->file->dateFolder = $dateFolder;
    }

    private function getDateFolder()
    {
        return $this->file->dateFolder;
    }

    private function getFilePathWithProvider($path, $provider)
    {
        $pathExplode = explode($path['path'], $path['pathfilename']);
        return $path['path'] . $provider . '/' . $pathExplode[1];
    }


}