<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Filemanager\Http\Requests\ThumbRequest;
use Modules\Filemanager\Repositories\ThumbControllerRepository;
use Modules\Filemanager\Thumb\Thumb;
use Pingpong\Modules\Facades\Module;

class ThumbController extends Controller
{
    /**
     * @var ThumbControllerRepository
     */
    private $thumb;

    public function __construct(ThumbControllerRepository $thumbApi, Thumb $thumb)
    {
        $this->thumbApi = $thumbApi;
        $this->thumb = $thumb;
    }

    public function index()
    {
        $thumbs = $this->thumbApi->all();
        $modules = Module::all();
        $this->thumb->get();
        return view('filemanager::popup.thumb.index')
            ->compact(array('thumbs','modules'));
    }

    public function create()
    {
        return view('filemanager::popup.thumb.create');
    }

    public function store(ThumbRequest $request)
    {
        $this->thumbApi->create($request->all());
    }


}
