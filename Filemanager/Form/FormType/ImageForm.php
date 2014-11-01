<?php  namespace Modules\Filemanager\Filemanager\Form\FormType;

class ImageForm extends AbstractFormFile
{
    public function execute($options = array())
    {
        $this->make($options);
        return $this;
    }

    public function __toString()
    {
        return $this->output();
    }

    protected function output()
    {
        return $this->make();
    }


}
