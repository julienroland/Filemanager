<?php  namespace Modules\Filemanager\Filemanager\Form;

use Illuminate\Config\Repository as Configuration;
use Illuminate\Support\Facades\Config;

class FileForm
{
    /**
     * @var TemplateFileUpload
     */
    private $fileTemplate;
    /**
     * @var Configuration
     */
    private $config;

    public function __construct(Configuration $config = null)
    {
        parent::__construct($config);
        $this->config = $config;
    }

    protected function inputTag()
    {
        return 'input';
    }

    protected function buttonTag()
    {
        return 'button';
    }

    protected function tag($tag)
    {
        return $tag;
    }

    protected function name()
    {
        return $this->nameAttr() . Config::get('filemanager::config.file_name');
    }

    protected function nameAttr()
    {
        return 'name=';
    }

    protected function nameMultipleFile()
    {
        return $this->nameAttr() . Config::get('filemanager::config.file_name') . '[]';
    }

    protected function type()
    {
        return 'type="' . $this->type . '"';
    }

    protected function id($id = null)
    {
        $id = is_null($id) ? Config::get('filemanager::config.file_name') : $id;
        return 'id="' . $id . '"';
    }

    protected function classes($class = null)
    {
        $class = is_null($class) ? Config::get('filemanager::config.classes_names') : $class;
        return 'class="' . $class . '"';
    }

    public function multipleAttr()
    {
        return 'multiple';
    }


}