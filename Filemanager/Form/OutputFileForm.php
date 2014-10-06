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

    /**
     * @param Configuration $config
     */
    public function __construct($config)
    {
        $this->config = $config;
    }

    public function createInputFile($type, $type2 = null)
    {
        return $this->outputInputFileTemplate($type, $type2);
    }

    public function createInputMultipleFile($type, $type2 = null)
    {
        return $this->outputInputFileMultipleTemplate($type, $type2);
    }

    protected function outputInputFileTemplate($type, $type2)
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->name() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
        echo $this->outputHiddenFieldTemplate($type, $type2);
    }

    protected function outputInputFileMultipleTemplate($type, $type2 = null)
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->nameMultipleFile() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
        echo $this->outputHiddenFieldTemplate($type, $type2);
    }


    private function openTag()
    {
        return '<';
    }

    private function closeTag()
    {
        return '/>';
    }

    private function outputHiddenFieldTemplate($value, $type = null)
    {
        $value = $this->createValueType($value, $type);

        return '<input type="hidden" ' . $this->nameAttr() . $this->config->get('filemanager::config.hidden_field_name') . ' value="' . $value . '"/>';
    }

    private function createValueType($value, $type)
    {
        if (!is_null($type)) {
            $value = $value . '::' . $type;
        }

        return $value;
    }

}
