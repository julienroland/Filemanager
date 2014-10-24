<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Filemanager\Http\Requests\ThumbRequest;
use Modules\Filemanager\Repositories\ThumbControllerRepository;
use Modules\Filemanager\Thumb\Thumb;

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
        dd($this->thumb->get());
        return view('filemanager::popup.thumb.index')
            ->with(compact(array('thumbs','modules')));
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
