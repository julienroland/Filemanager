<?php  namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Modules\Filemanager\Filemanager\Filemanager;
use Modules\Filemanager\Http\Requests\UploadRequest;

class TestController extends Controller
{

    /**
     * @var Filemanager
     */
    private $filemanager;

    public function __construct(Filemanager $filemanager)
    {
        $this->filemanager = $filemanager;
    }

    public function create(UploadRequest $request)
    {
        //$file = $request->file(Config::get('filemanager::config.file_name'));
        //$type = $request->get(Config::get('filemanager::config.hidden_field_name'));

        $this->filemanager
            ->make($request)
            ->resize(['width' => 100, 'height' => 100, 'ratio' => true])
            ->save();


    }
}