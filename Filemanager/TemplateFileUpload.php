<?php  namespace Modules\Filemanager\Filemanager;

use Modules\Filemanager\Filemanager\Form\OutputFileForm;

class TemplateFileUpload
{
    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @param OutputFileForm $outputFile
     */
    public function __construct(OutputFileForm $outputFile)
    {
        $this->outputFile = $outputFile;
    }

    public function file()
    {

        return $this->outputFile->createInputFile();
    }

    public function files()
    {
        return $this->outputFile->createInputMultipleFile();
    }
}