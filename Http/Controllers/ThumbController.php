<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Modules\Filemanager\Http\Requests\ThumbEditRequest;
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
    /**
     * @var Redirector
     */
    private $redirect;

    public function __construct(ThumbControllerRepository $thumbApi, Thumb $thumb, Redirector $redirect)
    {
        $this->thumbApi = $thumbApi;
        $this->thumb = $thumb;
        $this->redirect = $redirect;
    }

    public function index()
    {
        /*$thumbs = $this->thumbApi->all();*/
        $thumbs = $this->thumb->get();
        return view('filemanager::popup.thumb.index')
            ->with(compact(array('thumbs')));
    }

    public function create()
    {
        $modules = Module::all();
        return view('filemanager::popup.thumb.create')
            ->with(compact('modules'));
    }

    public function edit(ThumbEditRequest $request)
    {
        $thumb = $this->thumb->find($request->get('module'), $request->get('thumb'));
        $thumbs_available = $this->thumb->availables();
        return view('filemanager::popup.thumb.edit')->with(compact('thumb'));
    }

    public function store(ThumbRequest $request)
    {
        $fileVariantType = $this->thumbApi->create($request->all());
        return $this->redirect->back();
    }


}
