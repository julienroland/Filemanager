<?php  namespace Modules\Filemanager\Filemanager\Form;

use Illuminate\Support\Facades\Config;
use Illuminate\Config\Repository as Configuration;

class OutputFileForm extends FileForm
{
    protected $type = 'file';
    /**
     * @var Illuminate\Config\Repository
     */
    private $config;

    public function __construct()
    {
    }

    public function createInputFile($type)
    {
        return $this->outputInputFileTemplate($type);
    }

    public function createInputMultipleFile($type)
    {
        return $this->outputInputFileMultipleTemplate($type);
    }

    protected function outputInputFileTemplate($type)
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->name() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
        echo $this->outputHiddenFieldTemplate($type);
    }

    protected function outputInputFileMultipleTemplate($type)
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->nameMultipleFile() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
        echo $this->outputHiddenFieldTemplate($type);
    }


    private function openTag()
    {
        return '<';
    }

    private function closeTag()
    {
        return '/>';
    }

    private function outputHiddenFieldTemplate($value)
    {
        return '<input type="hidden" '.$this->nameAttr().Config::get('filemanager::config.hidden_field_name'). ' value="' . $value . '"/>';
    }

}
