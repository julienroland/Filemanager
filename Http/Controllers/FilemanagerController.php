<?php namespace Modules\Filemanager\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Laracasts\Flash\FlashNotifier;
use Modules\Filemanager\Filemanager\FileManager;
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
     * @var ImageManager
     */
    private $image;

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
        AjaxUploadRequest $ajaxRequest,
        FileManager $file
    ) {
        $this->flash = $flash;
        $this->redirect = $redirect;
        $this->request = $request;
        $this->ajaxRequest = $ajaxRequest;
        $this->file = $file;
    }


    /**
     * @param UploadRequest $request
     */
    public function upload()
    {
        if ($this->request->ajax()) {
            return $this->ajaxUpload();
        }
        return $this->syncUpload();
    }

    private function ajaxUpload()
    {
        $file = $this->ajaxRequest->file(Config::get('filemanager::config.file_name'));
        $params = $this->ajaxRequest->get(Config::get('filemanager::config.file_params_directory'));
        $type = $this->findFileType($file);
        $file = $this->file->make($file, $type, $params)->variant([
            'resize' =>
                [
                    'name' => 'icon',
                    'width' => 60,
                    'height' => 60
                ]
        ])->save();

        return $file;
    }

    /**
     * @param $file
     * @return int|string
     */
    private function findFileType($file)
    {
        foreach ($this->getMimes() as $type => $extensions) {
            foreach ($extensions as $extension) {
                if ($file->getClientMimeType() === $extension) {
                    return $type;
                }
            }
        }
    }
    private function syncUpload()
    {
        $input = $this->request->all();

        $fileType = $this->findFileType($this->getFileinput($this->request));

        $this->routeFileByType($input, $fileType);
    }

    private function getMimes()
    {
        return $this->mimes;
    }
}
