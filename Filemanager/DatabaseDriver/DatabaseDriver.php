<?php namespace Modules\Filemanager\Filemanager\DatabaseDriver;

use Cartalyst\Sentinel\Sentinel;
use Modules\Filemanager\Repositories\FileAccessTypeRepository;
use Modules\Filemanager\Repositories\FileRepository;
use Modules\Filemanager\Repositories\FileTypeRepository;

class DatabaseDriver
{
    /**
     * @var FileRepository
     */
    private $database;
    /**
     * @var FileAccessTypeRepository
     */
    private $fileAccess;
    /**
     * @var Sentinel
     */
    private $auth;
    /**
     * @var FileTypeRepository
     */
    private $fileType;

    /**
     * @param FileRepository $database
     * @param FileAccessTypeRepository $fileAccessType
     * @param FileTypeRepository $fileType
     * @param Sentinel $auth
     */
    public function __construct(
        FileRepository $file,
        FileAccessTypeRepository $fileAccessType,
        FileTypeRepository $fileType,
        Sentinel $auth
    ) {
        $this->file = $file;
        $this->fileAccessType = $fileAccessType;
        $this->fileType = $fileType;
        $this->auth = $auth;
    }

    /*   'name' =>$file->name,
                'group' =>,
                'slug' =>$file->slug,
                'extension' =>$file->extension,
                'mime' =>$file->mime,
                'url' =>$path['pathfilename'],
                'virtual_url' =>$path['virtual_path'],
                'width' =>$file->width(),
                'height' =>$file->height(),
                'size' =>,
                'timestamp' =>$file->timestamp,
                'external_url' =>,
                'file_access_type_id' =>,
    */
    public function create($file, $path, $provider)
    {
        $user = $this->auth->check() ? $this->auth->check()->id : null;
        $file = $this->file->create([
            'name' => $file->name,
            'group' => null,
            'slug' => $file->slug,
            'extension' => $file->extension,
            'mime' => $file->mime,
            'url' => $path['pathfilename'],
            'virtual_url' => $path['virtual_path'],
            'width' => $file->width(),
            'height' => $file->height(),
            'size' => null,
            'timestamp' => $file->timestamp,
            'external_url' => null,
            'file_access_type_id' => $this->getAccessType($provider),
            'user_id' => $user,
            'file_type_id' => $this->getFileType($file->type),
        ]);
        return $file;


    }

    private function getAccessType($provider)
    {
        switch ($provider) {
            case 'dropbox':
                return $this->fileAccessType->getIdByName('http');
                break;
            case null:
                return $this->fileAccessType->getIdByName('local');
                break;
        }
    }

    private function getFileType($type)
    {
        return $this->fileType->getIdByName($type);
    }
}