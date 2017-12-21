<?php namespace Modules\Filemanager\Filemanager\File;

use Modules\Filemanager\Repositories\FilesystemRepository;

class Filesystem
{
    /**
     * @var FilesystemRepository
     */
    private $file;

    public function __construct(FilesystemRepository $file)
    {
        $this->file = $file;
    }

    public function get($path)
    {
        return $this->file->get($path);
    }
    public function getRequire($path)
    {
        return $this->file->getRequire($path);
    }

    public function exists($path)
    {
        return $this->file->exists($path);
    }


    public function put($path, $contents)
    {
        return $this->file->put($path, $contents);
    }


    public function prepend($path, $data)
    {
        return $this->file->prepend($path, $data);
    }


    public function append($path, $data)
    {
        return $this->file->append($path, $data);
    }


    public function delete($paths)
    {
        return $this->file->delete($path);
    }


    public function move($path, $target)
    {
        return $this->file->move($path, $target);
    }


    public function copy($path, $target)
    {
        return $this->file->copy($path, $target);
    }


    public function extension($path)
    {
        return $this->file->extension($path);
    }


    public function type($path)
    {
        return $this->file->type($path);
    }


    public function size($path)
    {
        return $this->file->size($path);
    }


    public function isDirectory($directory)
    {
        return $this->file->isDirectory($directory);
    }

    public function isFile($file)
    {
        return $this->file->isFile($file);
    }


    public function glob($pattern, $flags = 0)
    {
        return $this->file->glob($pattern, $flags);
    }

    public function files($directory)
    {
        return $this->file->files($directory);
    }


    public function allFiles($directory)
    {
        return $this->file->allFiles($directory);
    }

    public function directories($directory)
    {
        return $this->file->directories($directory);
    }


    public function makeDirectory($path, $mode = 0755, $recursive = false, $force = false)
    {
        return $this->file->makeDirectory($path, $mode, $recursive, $force);
    }


    public function copyDirectory($directory, $destination, $options = null)
    {
        return $this->file->copyDirectory($directory, $destination, $options);
    }


    public function deleteDirectory($directory, $preserve = false)
    {
        return $this->file->deleteDirectory($directory, $preserve);
    }


    public function cleanDirectory($directory)
    {
        return $this->file->cleanDirectory($directory);
    }
}
