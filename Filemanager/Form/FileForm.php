<?php  namespace Modules\Filemanager\Filemanager\Form;

use Illuminate\Config\Repository as Configuration;
use Illuminate\Support\Facades\Config;

class FileForm
{
    /**
     * @var TemplateFileUpload
     */
    private $fileTemplate;

    public function __construct(Configuration $config = null)
    {
        parent::__construct($config);
    }

    protected function tag()
    {
        return 'input';
    }

    protected function name()
    {
        return $this->nameAttr() . Config::get('filemanager::config.file_name') ;
    }

    protected function nameAttr()
    {
        return 'name=';
    }

    protected function nameMultipleFile()
    {
        return $this->nameAttr() . Config::get('filemanager::config.file_name').'[]' ;
    }

    protected function type()
    {
        return 'type="' . $this->type . '"';
    }

    protected function id()
    {
        return 'id="' . Config::get('filemanager::config.id_name') . '"';
    }

    protected function classes()
    {
        return 'class="' . Config::get('filemanager::config.classes_names') . '"';
    }


}