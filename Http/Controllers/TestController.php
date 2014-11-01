<?php  namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Modules\Filemanager\Filemanager\Filemanager;
use Modules\Filemanager\Filemanager\Image\Image;
use Modules\Filemanager\Http\Requests\UploadRequest;

class TestController extends Controller
{

    /**
     * @var Filemanager
     */
    private $filemanager;
    /**
     * @var ImageManager
     */
    private $image;

    /**
     * @param Filemanager $filemanager
     * @param ImageManager $image
     */
    public function __construct(Filemanager $filemanager, Image $image)
    {
        $this->filemanager = $filemanager;
        $this->image = $image;
    }

    public function create(UploadRequest $request)
    {
        //$file = $request->file(Config::get('filemanager::config.file_name'));
        //$type = $request->get(Config::get('filemanager::config.hidden_field_name'));

        $file = $this->image
            ->make($request, 'file_filemanager')
            ->resize(100, 100)
            /*->variant(['resize' => ['width' => 100, 'height' => 100, 'ratio' => true]])*/
            ->save();

        //$class->attach($file);


    }
}
