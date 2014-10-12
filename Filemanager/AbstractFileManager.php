<?php  namespace Modules\Filemanager\Filemanager;

use Illuminate\Support\Facades\Config;

abstract class AbstractFileManager
{
    protected $todayDate;

    protected $folderPermissions = 0777;

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
    protected $string;
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
    protected $filesystem;


    protected function setImage($image)
    {
        $this->file = $image;
    }

    protected function setName()
    {
        $this->file->name = isset($this->file->name) ? $this->file->name : $this->file->getClientOriginalName();

    }

    protected function getFileFilename()
    {
        return $this->file->slug;
    }

    protected function getFilePath()
    {
        $dateFolder = $this->getFormatFolder();
        $this->setDateFolder($dateFolder);
        return $this->getDirectory($this->getFolderDir() . '/' . $dateFolder, $dateFolder);
    }

    /**
     * Get files's folder directory
     * @return string
     */
    protected function getFolderDir()
    {
        return public_path() . '/' . Config::get('filemanager::config.folder_dir');
    }

    protected function setToday()
    {
        $this->todayDate = $this->date->now();
    }

    protected function getFormatFolder()
    {
        $this->setToday();

        $year = $this->todayDate->year;
        $month = $this->todayDate->month;
        $day = $this->todayDate->day;

        return $year . '/' . $month . '/' . $day . '/';
    }

    protected function getTimestamp()
    {
        $this->setToday();
        return $this->todayDate->timestamp;
    }

    protected function getNameWithoutExtension($name = null)
    {
        if (is_null($name)) {
            $name = $this->file->name;
        }
        return explode('.' . $this->file->extension, $name)[0];
    }

    protected function getDirectory($destinationPath, $provider_path)
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

    protected function setSlug($name = null)
    {

        $this->setTimestamp();
        $this->setName();
        $this->setExtension();
        $this->file->slug = $this->string->slug($this->getTimestamp() . ' ' . $this->getNameWithoutExtension($name)) . '.' . $this->file->extension;
    }

    protected function getFile()
    {
        return $this->file;
    }

    protected function setFile($file)
    {

        $this->file = $file;
    }

    protected function getPath()
    {
        return [
            'path' => $this->getFormatFolder(),
            'virtual_path' => 'medias/' . $this->getFileType() . '/' . $this->getFileFilename(),
            'pathfilename' => $this->getFormatFolder() . $this->getFileFilename(),
            'fullPath' => $this->getFileFullPath(),
        ];
    }

    protected function getFileFullPath()
    {
        return $this->file->fullPath;
    }

    protected function setFileFullPath()
    {
        $this->setSlug();
        $provider = isset($this->provider) ? $this->provider . '/' : '';
        $fullpath = $this->getFilePath() . $provider . $this->getFileFilename();
        $this->file->fullPath = $fullpath;
    }

    protected function setTimestamp()
    {
        $this->file->timestamp = $this->getTimestamp();
    }

    protected function setExtension()
    {
        $this->file->extension = isset($this->file->extension) ? $this->file->extension : $this->file->guessExtension();
    }

    protected function setDateFolder($dateFolder)
    {
        $this->file->dateFolder = $dateFolder;
    }

    protected function getDateFolder()
    {
        return $this->file->dateFolder;
    }

    protected function hasAProvider()
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

    protected function setProvider($provider)
    {
        $this->provider = $provider;
    }

    protected function getProvider()
    {
        return $this->provider;
    }

    protected function setFileType($type = null)
    {

        $this->file->type = !is_null($type) ? $type : 'file';
    }

    protected function getFileType($type = null)
    {
        return $this->file->type;
    }
}