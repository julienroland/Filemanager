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
    protected $variant = false;
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
        if (!$this->isRequestAndSetFile($fileOrRequest)) {
            $this->setFile($fileOrRequest);
            $this->setFileType($type);
        }
        $this->changeToTypeFile();
        $this->hasAProvider();
        return $this;
    }

    public function save()
    {
        $this->setSlug();
        $this->setFileFullPath();
        $fileUploaded = $this->fileSaveInFolder();
        $filedatabased = $this->fileSaveToDatabase($this->variant);
        if ($this->variant === false) {
            $this->file->id = $filedatabased->id;
        }
        if ($fileUploaded) {
            echo 'Uploaded';
        }
        if ($filedatabased) {
            return $filedatabased;
        }
    }

    public function variant($variants)
    {
        $this->setFileFullPath();
        $this->save();

        $this->variant = true;
        foreach ($variants as $key => $variant) {
            $this->{$key}($variant);
        }
        return $this;
    }

    public function resize($options)
    {
        $this->setImage($this->image->resize($this->file, $options));
        $this->setVariantName($options);
        $this->setVariantPrefix($this->file,
            $this->getVariantPrefixName('resize', $this->outputImgSize($options)));
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
        $type = $this->file->type;
        $this->file = $this->image->make($file);
        $this->file->type = $type;
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
        $this->setToday();

        $year = $this->todayDate->year;
        $month = $this->todayDate->month;
        $day = $this->todayDate->day;

        return $year . '/' . $month . '/' . $day . '/';
    }

    private function getTimestamp()
    {
        $this->setToday();
        return $this->todayDate->timestamp;
    }

    private function getNameWithoutExtension($name = null)
    {
        if (is_null($name)) {
            $name = $this->file->name;
        }
        return explode('.' . $this->file->extension, $name)[0];
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

    private function setSlug($name = null)
    {

        $this->setTimestamp();
        $this->setName();
        $this->setExtension();
        $this->file->slug = $this->string->slug($this->getTimestamp() . ' ' . $this->getNameWithoutExtension($name)) . '.' . $this->file->extension;
    }


    private function getFile()
    {
        return $this->file;
    }

    private function isRequestAndSetFile($fileOrRequest)
    {

        if ($fileOrRequest instanceof UploadRequest) {

            if ($fileOrRequest->hasFile(Config::get('filemanager::config.file_name'))) {
                $file = $fileOrRequest->file(Config::get('filemanager::config.file_name'));
                $this->setFile($file);

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

        $this->file->type = !is_null($type) ? $type : 'file';
    }

    private function getFileType($type = null)
    {
        return $this->file->type;
    }

    private function changeToTypeFile()
    {
        $this->hasAProvider();
        switch ($this->file->type) {
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
        switch ($this->file->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, $this->getPath(), 'directory', $this->provider);
                break;
        }
    }


    private function fileSaveToDatabase($variant = false)
    {
        switch ($this->file->type) {
            case 'file':
                dd('save file');
                break;
            case 'image':
                return $this->image->save($this->file, $this->getPath(), 'database', $variant, $this->provider);
                break;
        }
    }

    private function getPath()
    {
        return [
            'path' => $this->getFormatFolder(),
            'virtual_path' => 'medias/' . $this->getFileType() . '/' . $this->getFileFilename(),
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
        $this->setSlug();
        $provider = isset($this->provider) ? $this->provider . '/' : '';
        $fullpath = $this->getFilePath() . $provider . $this->getFileFilename();
        $this->file->fullPath = $fullpath;
    }

    private function setFileFolders()
    {
        $this->file->folders = $this->getFileFolders();
    }


    private function hasAProvider()
    {
        $types = explode('::', $this->file->type);
        if (isset($types[1])) {
            $this->setFileType($types[1]);
            $this->setProvider($types[0]);
        } else {
            $this->setFileType($types[0]);
            $this->setProvider(null);
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

    private function setTimestamp()
    {
        $this->file->timestamp = $this->getTimestamp();
    }

    private function setExtension()
    {
        $this->file->extension = isset($this->file->extension) ? $this->file->extension : $this->file->guessExtension();
    }

    private function setName()
    {
        $this->file->name = isset($this->file->name) ? $this->file->name : $this->file->getClientOriginalName();

    }

    private function setVariantPrefix($file, $variant)
    {
        $file->slug = $this->addBeforeExtension($variant, $file->slug, $this->file->extension);
        $file->name = $this->addBeforeExtension($variant, $file->name, $this->file->extension);
    }

    private function addBeforeExtension($variant, $name, $extension)
    {
        $name = $this->getNameWithoutExtension($name);
        return $name . '-' . $variant . '.' . $extension;
    }

    private function getVariantPrefixName($string, $options)
    {
        return $string . '-' . $options;
    }

    private function outputImgSize($options)
    {
        return $options['width'] . 'x' . $options['height'];
    }

    private function setVariantName($options)
    {
        if (isset($options['name'])) {
            $this->file->variantName = $options['name'];
        } else {
            $this->file->variantName = null;
        }
    }


}