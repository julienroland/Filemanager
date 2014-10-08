<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Filemanager\Repositories\FileRepository;

class FileController extends Controller
{
    /**
     * @var FileRepository
     */
    private $file;

    public function __construct(FileRepository $file)
    {
        $this->file = $file;
    }

    public function outputLibrary()
    {
        $files = $this->file->all();
        return view('filemanager::popup.library')
            ->with(compact('files'));
    }
}