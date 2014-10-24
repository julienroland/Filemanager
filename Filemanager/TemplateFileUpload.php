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

    public function image($params = null)
    {
        $button = $this->outputFile->createButtonLibrary('image');
        $file = $this->outputFile->createInputFile('image', $params);
        return $button . $file;
    }

    public function images($params = null)
    {
        $button = $this->outputFile->createButtonLibrary('image');
        $file = $this->outputFile->createInputMultipleFile('image', $params);
        return $button . $file;
    }

    public function attachImage($formName = null, $label = null, $params = null)
    {
        $button = $this->outputFile->createButtonLibrary('image', null, $formName, $label);
        $js = $this->outputFile->outputJsOpenLibrary($button, $formName);
        $file = $this->outputFile->createInputFile('image', $params);
        $hidden = $this->outputFile->createInputHidden($formName, $params);
    }

    public function attachImages($formName = "image", $label = null, $params = null)
    {
        $button = $this->outputFile->createButtonLibrary('image', null, $label);
        $file = $this->outputFile->createInputMultipleFile('image', $params);
        $hidden = $this->outputFile->createInputHidden($formName, $params);

        return $button . $file . $hidden;
    }

    public function library($params = null)
    {
        $button = $this->outputFile->createButtonLibrary('image');
        $file = $this->outputFile->createInputFile('image', $params);
        return $button . $file;
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
