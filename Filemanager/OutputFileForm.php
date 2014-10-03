<?php  namespace Modules\Filemanager\Filemanager;


use Illuminate\Support\Facades\Config;
use Illuminate\Config\Repository as Configuration;

class OutputFileForm
{
    /**
     * @var Illuminate\Config\Repository
     */
    private $config;

    public function __construct(Configuration $config)
    {
        dd($config);
    }

    protected function outputInputFileTemplate()
    {
        echo '<input type="file" name="' . Config::get('filemanager::config.file_name') . '" id="' . Config::get('filemanager::config.file_name') . '"/>';
    }

    protected function createInputMultipleFile()
    {
        echo '<input type="file" name="' .Config::get('filemanager::config.file_name') . '[]" id="' . Config::get('filemanager::config.file_name') . '"/>';
    }
}