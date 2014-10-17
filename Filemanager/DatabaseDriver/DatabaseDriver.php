<?php namespace Modules\Filemanager\Filemanager\DatabaseDriver;

use Cartalyst\Sentinel\Sentinel;
use Modules\Filemanager\Repositories\FileAccessTypeRepository;
use Modules\Filemanager\Repositories\FileRepository;
use Modules\Filemanager\Repositories\FileTypeRepository;
use Modules\Filemanager\Repositories\FileVariantRepository;

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
     * @var FileVariantRepository
     */
    private $fileVariant;

    /**
     * @param FileRepository $database
     * @param FileAccessTypeRepository $fileAccessType
     * @param FileTypeRepository $fileType
     * @param Sentinel $auth
     */
    public function __construct(
        FileRepository $file,
        FileVariantRepository $fileVariant,
        FileAccessTypeRepository $fileAccessType,
        FileTypeRepository $fileType,
        Sentinel $auth
    ) {
        $this->file = $file;
        $this->fileVariant = $fileVariant;
        $this->fileAccessType = $fileAccessType;
        $this->fileType = $fileType;
        $this->auth = $auth;
    }

    public function create($file, $path, $variant, $provider)
    {
        $params = $file->params;
        if ($variant) {
            $file = $this->createVariant($file, $path, $provider);
        } else {
            $file = $this->createFile($file, $path, $provider);
            if (!is_null($params)) {
                $this->attachFileToFolder($file, $params);
            }

        }

        return $this->file->find($file->id);

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

    private function createFile($file, $path, $provider)
    {
        $user = $this->auth->check() ? $this->auth->check()->id : null;

        return $this->file->create([
            'name' => $file->name,
            'group' => null,
            'slug' => $file->slug,
            'extension' => $file->extension,
            'mime' => $file->mime,
            'url' => $path['pathfilename'],
            'virtual_url' => $path['virtual_path'],
            'width' => $file->width(),
            'height' => $file->height(),
            'size' => $file->size,
            'timestamp' => $file->timestamp,
            'external_url' => null,
            'file_access_type_id' => $this->getAccessType($provider),
            'user_id' => $user,
            'file_type_id' => $this->getFileType($file->type),
        ]);

    }

    private function createVariant($file, $path, $provider)
    {
        $this->fileVariant->create([
            'name' => $file->name,
            'group' => $file->variantName,
            'slug' => $file->slug,
            'url' => $path['pathfilename'],
            'width' => $file->width(),
            'height' => $file->height(),
            'size' => $file->size,
            'file_id' => $file->id,
        ]);

        return $this->file->find($file->id);
    }

    private function attachFileToFolder($file, $params)
    {
        return $this->file->append($file->id, (int)$params);
    }
}