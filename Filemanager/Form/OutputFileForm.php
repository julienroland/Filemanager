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

    public function createInputFile($type, $params = null, $type2 = null)
    {
        return $this->outputInputFileTemplate($type, $params, $type2);
    }

    public function createInputMultipleFile($type, $params = null, $type2 = null)
    {
        return $this->outputInputFileMultipleTemplate($type, $params $type2);
    }

    public function createButtonLibrary($type, $type2 = null)
    {
        return $this->outputButtonLibraryTemplate($type, $type2);
    }


    protected function outputInputFileTemplate($type, $params = null, $type2)
    {
        echo $this->openTag() . $this->inputTag() . ' ' . $this->type() . ' ' . $this->name() . ' ' . $this->classes('hidden') . ' ' . $this->id() . ' ' . $this->inlineCloseTag();
        echo $this->outputHiddenFieldTemplate($type, $params, $type2);
    }

    protected function outputInputFileMultipleTemplate($type, $params = null, $type2 = null)
    {
        echo $this->openTag() . $this->inputTag() . ' ' . $this->type() . ' ' . $this->nameMultipleFile() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->multipleAttr() . ' ' . $this->inlineCloseTag();
        echo $this->outputHiddenFieldTemplate($type, $params, $type2);
    }

    private function outputButtonLibraryTemplate($type, $type2)
    {
        echo $this->openTag() . $this->buttonTag() . ' ' . $this->classes($this->config->get('filemanager::config.library_class')) . ' ' . $this->id($this->config->get('filemanager::config.library_class')) . $this->closeTag() . trans('filemanager::form.upload') . $this->buttonCloseTag();
        //echo $this->outputHiddenFieldTemplate($type, $type2);
    }

    private function openTag()
    {
        return '<';
    }

    private function inlineCloseTag()
    {
        return '/>';
    }

    private function closeTag()
    {
        return '/>';
    }

    private function outputHiddenFieldTemplate($value, $params = null, $type = null)
    {
        $inputHidden = '';

        $value = $this->createValueType($value, $type);
        $inputHidden .= '<input type="hidden" ' . $this->nameAttr() . $this->config->get('filemanager::config.hidden_field_name') . ' value="' . $value . '"/>';

        if (!is_null($params)) {
            foreach ($params as $name => $value) {
                $inputHidden .= '<input type="hidden" ' . $this->nameAttr() . $name . ' value="' . $value . '"/>';
            }

        }

        return $inputHidden;
    }

    private function createValueType($value, $type)
    {
        if (!is_null($type)) {
            $value = $value . '::' . $type;
        }
        return $value;
    }

    private function value($trans)
    {
        return 'value="' . $trans . '"';
    }

    private function buttonCloseTag()
    {
        return '</button>';
    }


}
