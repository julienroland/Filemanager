<?php  namespace Modules\Filemanager\Filemanager\Form;

use RuntimeException;

class FormDriver
{
    private $fileFormTypePath = "Modules\\Filemanager\\Filemanager\\Form\\FormType\\%s";

    public function executeFileType($typeName, $options)
    {
        $fileTypeName = $this->getFileTypeName($typeName);
        $fileForm = new $fileTypeName($options);
        $fileForm->execute($options);

        return $fileForm;
    }

    private function getFileTypeName($typeName)
    {
        $className = sprintf($this->fileFormTypePath, ucfirst($typeName).'Form');
        if (class_exists($className)) {
            return $className;
        }
        throw new RuntimeException("Filemanager FormType FileType ({$typeName}) not found.");
    }
}
