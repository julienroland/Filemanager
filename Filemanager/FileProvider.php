<?php  namespace Modules\Filemanager\Filemanager;

class FileProvider
{
    /**
     * @var FileManager
     */
    private $file;

    public function __construct(FileManager $file)
    {
        $this->file = $file;
    }

    protected function isDirectory($type)
    {
        return $type === 'directory';
    }

    protected function isDatabase($type)
    {
        return $type === 'database';
    }

    protected function getFileFullPath($file)
    {
        return $file->fullPath;
    }

}