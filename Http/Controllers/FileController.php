<?php namespace Modules\Filemanager\Http\Controllers;

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

    public function outputLibrary()
    {
        $files = $this->file->all();
        $directories = $this->directory->all();
        return view('filemanager::popup.library')
            ->with(compact('files', 'directories'));
    }
}