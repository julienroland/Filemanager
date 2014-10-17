<?php  namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;
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

    public function create(Request $request)
    {
        return $this->directory->create($request->get('name'));
    }

    public function update($id, Request $request)
    {
        return $this->directory->update($id, $request);
    }

    public function append($folder1_id, $folder2_id)
    {
        return $this->directory->append($folder1_id, $folder2_id);
    }

}