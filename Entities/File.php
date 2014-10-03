<?php  namespace Modules\Filemanager\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Filemanager\Repositories\FileRepository;

class File
{
    protected $table = "files";

    /**
     * @var
     */
    private $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function create($file)
    {
        return $this->file->createFile($file);
    }

}