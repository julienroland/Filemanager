<?php  namespace Modules\Filemanager\Filemanager\Image;

use RuntimeException;

abstract class AbstractImageDriver
{
    private $variantPath = 'Modules\\Filemanager\\Filemanager\\Image\\Manipulations\\%s';

    public function executeVariant($image, $name, $options)
    {
        $variantName = $this->getVariantName($name);
        $variant = new $variantName($options);
        $variant->make($image);

        return $variant;
    }

    private function getVariantName($name)
    {
        $className = sprintf($this->variantPath, ucfirst($name));
        if (class_exist($className)) {
            return $className;
        }
        throw new RuntimeException("Variant ({$name}) not found.");
    }

}
