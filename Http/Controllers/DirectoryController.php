<?php  namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Filemanager\Repositories\FileDirectoryRepository;

class DirectoryController extends Controller
{
    /**
     * @var FileDirectoryRepository
     */
    private $directory;

    public function __construct(FileDirectoryRepository $directory)
    {
        $this->directory = $directory;
    }

    public function create($data = array())
    {
        return $this->directory->create($data);
    }
}