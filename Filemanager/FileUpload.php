<?php  namespace Modules\Filemanager\Filemanager;

class FileUpload extends FileManager
{

    public function file()
    {
        return $this->createInputFile();
    }

    public function files()
    {
        return $this->createInputMultipleFile();
    }
}