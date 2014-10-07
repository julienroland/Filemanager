<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Laracasts\Flash\FlashNotifier;
use Modules\Filemanager\Http\Requests\UploadRequest;
use Modules\Filemanager\Http\Requests\AjaxUploadRequest;

class FilemanagerController extends Controller
{

    protected $ajax = false;
    protected $mimes = [
        'image' => [
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpg',
            'gif' => 'image/gif',
            'png' => 'image/png',
            'tiff' => 'image/tiff',
            'icon' => 'image/vnd.microsoft.icon',
            'svg' => 'image/svg+xml',
        ],
        'application' => [
            'javascript' => 'application/javascript',
            'pdf' => 'application/pdf',
            'xhtml' => 'application/xhtml+xml',
            'xml' => 'application/xml',
            'flash' => 'application/x-shockwave-flash',
            'json' => 'application/json',
            'zip' => 'application/zip',
        ],
        'audio' => [
            'mpeg' => 'audio/mpeg',
            'wav' => 'audio/x-wav',
        ],
        'multipart' => [
            'mixed' => 'multipart/mixed',
            'alternative' => 'multipart/alternative',
            'related' => 'multipart/related',
        ],
        'text' => [
            'css' => 'text/css',
            'csv' => 'text/csv',
            'html' => 'text/html',
            'plain' => 'text/plain',
            'xml' => 'text/xml',
        ],
        'video' => [
            'mpeg' => 'video/mpeg',
            'mp4' => 'video/mp4',
            'quicktime' => 'video/quicktime',
            'windows_media' => 'video/x-ms-wmv',
            'avi' => 'video/x-msvideo',
            'flv' => 'video/x-flv',
        ]
    ];
    /**
     * @var
     */
    private $filemanager;
    /**
     * @var Flash
     */
    private $flash;
    /**
     * @var Redirect
     */
    private $redirect;
    /**
     * @var UploadRequest
     */
    private $request;
    /**
     * @var AjaxUploadRequest
     */
    private $ajaxRequest;

    /**
     * @param FilemanagerControllerRepository $filemanager
     * @param FlashNotifier|Flash $flash
     * @param Redirector|Redirect $redirect
     * @param UploadRequest $request
     */
    public function __construct(
        FlashNotifier $flash,
        Redirector $redirect,
        UploadRequest $request,
        AjaxUploadRequest $ajaxRequest
    ) {
        $this->flash = $flash;
        $this->redirect = $redirect;
        $this->request = $request;
        $this->ajaxRequest = $ajaxRequest;
    }


    /**
     * @param UploadRequest $request
     */
    public function upload()
    {

        if ($this->request->ajax()) {

            $this->ajaxUpload();
        }

        $this->syncUpload();

    }

    /**
     * @param $file
     * @return int|string
     */
    private
    function findFileType(
        $file
    ) {
        foreach ($this->getMimes() as $type => $extensions) {
            foreach ($extensions as $extension) {
                if ($file->getClientMimeType() === $extension) {
                    return $type;
                }
            }
        }
    }

    /**
     * @param $file
     * @param $fileType
     * @return mixed|void
     */
    private
    function routeFileByType(
        $input,
        $fileType
    ) {

        switch ($fileType) {
            case 'image':
                return $this->imageUpload($input);
                break;
            case 'application':
                return $this->applicationUpload($input);
                break;
            case 'audio':
                return $this->audioUpload($input);
                break;
            case 'video':
                return $this->videoUpload($input);
                break;
            case 'multipart':
                return $this->multipartUpload($input);
                break;
            case 'text':
                return $this->TextUpload($input);
                break;
        }
    }

    /**
     * @param $file
     * @return mixed
     */
    private
    function imageUpload(
        $file
    ) {
        return Image::make($file);
    }


    /**
     * @param $file
     */
    private
    function applicationUpload(
        $file
    ) {
        return $this->move($file[Config::get('filemanager::config.file_name')]);
    }

    /**
     * @param $file
     */
    private
    function audioUpload(
        $file
    ) {
    }

    /**
     * @param $file
     */
    private
    function videoUpload(
        $file
    ) {
    }

    /**
     * @param $file
     */
    private
    function multipartUpload(
        $file
    ) {
    }

    /**
     * @param $file
     */
    private
    function TextUpload(
        $file
    ) {
    }

    /**
     * @return array
     */
    public
    function getMimes()
    {
        return $this->mimes;
    }

    /**
     * @param UploadRequest $request
     * @return mixed
     */
    private
    function getFileinput(
        UploadRequest $request
    ) {
        return $request->file(Config::get('filemanager::config.file_name'));
    }

    /**
     * @param $file
     * @return \Illuminate\Http\RedirectResponse
     */
    private
    function move(
        $file
    ) {
        return $this->response($this->moving($file));
    }

    /**
     * @return mixed
     */
    private
    function getFilePath()
    {
        return $this->filemanager->getFilePath();
    }

    /**
     * @param $file
     * @return mixed
     */
    private
    function moving(
        $file
    ) {
        dd('ok');
        return $file->move($this->getFilePath(), $file->getClientOriginalName());
    }

    /**
     * @param $response
     * @return \Illuminate\Http\RedirectResponse
     */
    private
    function response(
        $response
    ) {

        if ($response) {
            $this->flash->success(trans('filemanager::upload.success'));
            return $this->redirect->back();
        }

        $this->flash->error(trans('filemanager::upload.error'));
        return $this->redirect->back();

    }

    /**
     * @param AjaxUploadRequest $request
     */
    private function ajaxUpload()
    {
        $this->setAjax(true);
        //faire la requete ajax
        dd($this->ajaxRequest->all());
        dd($this->ajaxRequest->has(Config::get('filemanager::config.file_name')));

    }

    /**
     *
     */
    private function syncUpload()
    {
        $input = $this->request->all();

        $fileType = $this->findFileType($this->getFileinput($this->request));

        $this->routeFileByType($input, $fileType);
    }

    /**
     * @param boolean $ajax
     */
    public function setAjax($ajax)
    {
        $this->ajax = $ajax;
    }
}
