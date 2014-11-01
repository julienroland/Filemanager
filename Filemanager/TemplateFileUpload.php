<?php  namespace Modules\Filemanager\Filemanager;

use Modules\Filemanager\Filemanager\Form\FormDriver;
use Modules\Filemanager\Filemanager\Form\OutputFileForm;

class TemplateFileUpload
{
    /**
     * @var AbstractFormDriver
     */
    private $driver;

    /**
     * @param OutputFileForm $outputFile
     * @param AbstractFormDriver $driver
     * @internal param $config
     */
    public function __construct(OutputFileForm $outputFile, FormDriver $driver)
    {
        $this->outputFile = $outputFile;
        $this->driver = $driver;
    }

    public function __call($typeName, $options)
    {
        $fileForm = $this->driver->executeFileType($typeName, $options);
        return $fileForm;
    }

    /*   public function file()
       {
           return $this->outputFile->createInputFile('file');
       }

       public function files()
       {
           return $this->outputFile->createInputMultipleFile('file');
       }

       public function thumbs($defaultValue = null)
       {
           return $this->outputFile->createThumbForm($defaultValue);
       }

       public function dropbox($type)
       {
           return $this->outputFile->createInputFile('dropbox', $type);
       }

       public function dropboxes()
       {
           return $this->outputFile->createInputMultipleFile('dropbox');
       }*/


    /*   public function image($name = null, $params = null)
       {
           $button = $this->outputFile->createButtonLibrary('image');
           $file = $this->outputFile->createInputFile('image', $name, $params);
           return $button . $file;
       }*/

    /*  public function images($params = null)
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
      }*/

}
