<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Filemanager\Repositories\FileDirectoryRepository;
use Modules\Filemanager\Repositories\FileRepository;

class FileController extends Controller
{
    /**
     * @var FileRepository
     */
    private $file;
    /**
     * @var FileDirectoryRepository
     */
    private $directory;

    public function __construct(FileRepository $file, FileDirectoryRepository $directory)
    {
        $this->file = $file;
        $this->directory = $directory;
    }

    public function outputLibrary(Request $request)
    {
        $id = $request->get('directory');
        $files = $this->file->getByDirectories($id);
        $directories = $this->directory->get($id);
        return view('filemanager::popup.library')
            ->with(compact('files', 'directories'));
    }

    public function update($id, Request $request)
    {
        return $this->file->update($id, $request);
    }

    public function append($file_id, $folder_id)
    {
        return $this->file->append($file_id, $folder_id);
    }

    public function delete($id)
    {
        return $this->file->delete($id);
    }

}