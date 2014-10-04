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

    public function createInputFile()
    {

        return $this->outputInputFileTemplate();
    }

    public function createInputMultipleFile()
    {
        return $this->outputInputFileMultipleTemplate();
    }

    protected function outputInputFileTemplate()
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->name() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
    }

    protected function outputInputFileMultipleTemplate()
    {
        echo $this->openTag() . $this->tag() . ' ' . $this->type() . ' ' . $this->nameMultipleFile() . ' ' . $this->classes() . ' ' . $this->id() . ' ' . $this->closeTag();
    }


    private function openTag()
    {
        return '<';
    }

    private function closeTag()
    {
        return '/>';
    }

}
