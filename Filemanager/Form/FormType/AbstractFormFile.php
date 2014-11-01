<?php  namespace Modules\Filemanager\Filemanager\Form\FormType;

abstract class AbstractFormFile
{
    protected $type = '';
    protected $name = '';
    protected $button = '';
    protected $label = '';
    protected $id = '';
    protected $class = '';

    abstract protected function output();

    abstract public function execute($options = array());


    public function label($label = null)
    {
        $for = '';
        if (isset($this->name) || isset($this->id)) {
            $for = $this->name;
        }
        if (!is_null($label)) {
            $this->label = ' <label for="' . $for . '" > ' . $label . '</label > ';
        }
        return $this;
    }

    public function classes($class = null)
    {
        if (!is_array($class)) {
            $this->class .= ' class=' . $class;
        } else {
            $classes = ' class="';
            if (!is_null($class)) {
                foreach ($class as $oneClass) {
                    $classes .= ' ' . $oneClass;
                }
                $this->class = $classes . '"';
            }
        }
        return $this;
    }

    public function id($id = null)
    {
        if (!is_array($id)) {
            $this->id .= ' id=' . $id;
        } else {
            $ids = ' id="';
            if (!is_null($id)) {
                foreach ($id as $oneId) {
                    $ids .= ' ' . $oneId;
                }
                $this->id = $ids . '"';
            }
        }
        return $this;
    }

    public function name($name = null)
    {
        if (!is_null($name)) {
            $this->id .= ' ' . $name;
            $this->name = ' name="' . $name . '"';
        }

        return $this;
    }

    protected function type($type = null)
    {
        if (is_null($type)) {
            $type = 'file';
        }
        return ' type = "' . $type . '"';
    }

    protected function inputOpenTag()
    {
        return ' <input ';
    }

    protected function inputCloseTag()
    {
        return ' /> ';
    }

    protected function button($value = null)
    {
        if (is_null($value)) {
            $value = trans('filemanager::form.upload');
        }
        return ' <button>' . $value . ' </button> ';
    }

    public function make($options = array())
    {
        return
            $this->label .
            $this->button .
            $this->inputOpenTag() .
            $this->type('file') .
            $this->id .
            $this->class .
            $this->name .
            $this->inputCloseTag();
    }
}
