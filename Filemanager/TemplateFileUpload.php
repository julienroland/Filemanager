<?php  namespace Modules\Filemanager\Filemanager;

use Modules\Filemanager\Filemanager\Form\OutputFileForm;

class TemplateFileUpload
{
    /**
     * @var FileManager
     */
    private $fileManager;
    private $config;

    /**
     * @param $config
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

    public function dropbox($type)
    {
        return $this->outputFile->createInputFile('dropbox', $type);
    }

    public function dropboxes()
    {
        return $this->outputFile->createInputMultipleFile('dropbox');
    }

    public function image()
    {

        $button = $this->outputFile->createButtonLibrary('image');
        $file = $this->outputFile->createInputFile('image');

        return $button . $file;
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