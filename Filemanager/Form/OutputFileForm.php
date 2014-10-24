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

    public function createInputHidden($formName, $params)
    {
        echo $this->outputHiddenFieldTemplate(null, $params, null, $formName);
    }

    public function createInputMultipleFile($type, $params = null, $type2 = null)
    {
        return $this->outputInputFileMultipleTemplate($type, $params, $type2);
    }

    public function createButtonLibrary($type, $type2 = null, $formName = null, $label = null)
    {
        return $this->outputButtonLibraryTemplate($type, $type2, $formName, $label);
    }

    public function outputJsOpenLibrary($button, $formName)
    {
        return $this->outputJsOpenLibraryTemplate($button);
    }

    private function outputJsOpenLibraryTemplate($button)
    {
        echo '<script type="text/javascript"> var button = document.getElementById("' . $button . '"); button.addEventListener("click",function(){ window.open("/filemanager/library");})</script>';
    }

    protected function outputInputFileTemplate($type, $params = null, $type2)
    {
        echo $this->openTag() . $this->inputTag() . ' ' . $this->type() . ' ' . $this->name() . ' ' . $this->params($params) . ' ' . $this->classes('hidden') . ' ' . $this->id() . ' ' . $this->inlineCloseTag();
        echo $this->outputHiddenFieldTemplate($type, $params, $type2);
    }

    protected function outputInputFileMultipleTemplate($type, $params = null, $type2 = null)
    {
        echo $this->openTag() . $this->inputTag() . ' ' . $this->type() . ' ' . $this->nameMultipleFile() . ' ' . $this->classes('hidden') . ' ' . $this->id() . ' ' . $this->multipleAttr() . ' ' . $this->fileMultiple() . $this->inlineCloseTag();
        echo $this->outputHiddenFieldTemplate($type, $params, $type2);
    }


    private function outputButtonLibraryTemplate($type, $type2, $formName, $label)
    {
        if (is_null($label)) {
            $label = trans('filemanager::form.library');
        }

        if (is_null($formName)) {
            $class = $this->config->get('filemanager::config.library_class');
        } else {
            $class = $formName . '_' . $this->config->get('filemanager::config.library_class');
        }

        echo $this->openTag() . $this->inputTag() . ' ' . $this->type('button') . ' ' . $this->classes($class) . ' ' . $this->id($class) . ' ' . $this->value($label) . $this->closeTag();

        return $class;
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

    private function outputHiddenFieldTemplate($value, $params = null, $type = null, $name = null)
    {
        $inputHidden = '';
        if (is_null($name)) {
            $name = $this->config->get('filemanager::config.hidden_field_name');
        }
        $value = $this->createValueType($value, $type);
        $inputHidden .= '<input type="hidden" ' . $this->nameAttr() . $name . '" value="' . $value . '"/>';

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


    private function buttonCloseTag()
    {
        return '</button>';
    }

    private function params($params = null)
    {
        if (!is_null($params)) {
            return 'data-form-data=' . json_encode($params);
        }
    }

}
