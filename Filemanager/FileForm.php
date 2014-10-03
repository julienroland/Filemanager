<?php  namespace Modules\Filemanager\Filemanager;
use Illuminate\Config\Repository as Configuration;
class FileForm extends OutputFileForm
{

    public function __construct(Configuration $config = null){
        parent::__construct($config);
    }

    public function createInputFile()
    {
        return $this->outputInputFileTemplate();
    }

    public function createInputMultipleFile()
    {
        return $this->OutputInputMultipleFileTemplate();
    }


}