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
        return $this->outputFile->createInputFile('file');
    }

    public function files()
    {
        return $this->outputFile->createInputMultipleFile('file');
    }

    public function image()
    {
        return $this->outputFile->createInputFile('image');
    }

    public function images()
    {
        return $this->outputFile->createInputMultipleFile('image');
    }

    public function audio()
    {
        return $this->outputFile->createInputFile('audio');
    }

    public function audios()
    {
        return $this->outputFile->createInputMultipleFile('audio');
    }

    public function zip()
    {
        return $this->outputFile->createInputFile('zip');
    }

    public function zips()
    {
        return $this->outputFile->createInputMultipleFile('zip');
    }

    public function video()
    {
        return $this->outputFile->createInputFile('video');
    }

}