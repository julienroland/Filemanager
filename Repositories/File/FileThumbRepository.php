<?php  namespace Modules\Filemanager\Repositories\File;

use Illuminate\Support\Collection;
use Modules\Filemanager\Filemanager\File\Filesystem;
use Modules\Filemanager\Repositories\ThumbRepository;
use Pingpong\Modules\Facades\Module;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Illuminate\Config\Repository as Configuration;

class FileThumbRepository implements ThumbRepository
{
    /**
     * @var Filesystem
     */
    private $file;
    /**
     * @var Config
     */
    private $config;

    public function __construct(Filesystem $file, Configuration $config)
    {
        $this->file = $file;
        $this->config = $config;
    }

    public function find($module_name, $thumb_name)
    {
        try {
            $configPath = $this->getModuleThumbConfig($module_name);
            $data = $this->getFileToArray($configPath);
            try {
                return $this->findThumbFromThumbsList($thumb_name, $data);

            } catch (FileNotFoundException $e) {
                return $e;
            }
        } catch (FileNotFoundException $e) {
            return $e;
        }
    }

    public function get()
    {
        $modules = Module::all();
        $thumbs = [];
        foreach ($modules as $module) {
            $configPath = $this->getModuleThumbConfig($module);
            if ($this->file->exists($configPath)) {
                $file = $this->file->getRequire($configPath);
                if (is_array($file)) {
                    $thumbs[$module] = $file;
                }
            }
        }
        return $thumbs;
    }

    public function add($modulesList, $fileVariantType)
    {
        $modules = $modulesList;

        foreach ($modules as $module => $value) {
            $this->addOrEditConfigFile($module, $fileVariantType);
        }
        return true;
    }

    public function create()
    {
        $modules = Module::all();
        $thumbKey = $this->config->get('filemanager::config.thumb_config_key');

        foreach ($modules as $module) {
            try {
                $configPath = $this->getModuleThumbConfig($module);
                $baseThumbConfig = array('Thumb' => array());
                $config = new Collection($this->file->getRequire($configPath));
                if (isset($config[$thumbKey])) {
                    $config->forget($thumbKey);
                }
                /* $config->put($thumbKey,
                     $baseThumbConfig[$thumbKey]);*/
                $newConfig = "<?php\nreturn " . var_export($config->toArray(), true) . ";\n";
                $test = $this->file->put($configPath, $newConfig);
            } catch (FileNotFoundException $e) {
                return $e;
            }
        }
    }

    private function addOrEditConfigFile(
        $module,
        $fileVariantType
    ) {
        $variants = toArray(json_decode($fileVariantType->value));
        $thumbKey = $this->config->get('filemanager::config.thumb_config_key');
        $configPath = base_path() . '/Modules/' . $module . '/Config/thumb.php';
        if (!$this->file->exists($configPath)) {
            $this->file->makeDirectory($configPath, 0755, true);
        }
        $baseThumbConfig = array($thumbKey => $variants);
        $config = $this->file->getRequire($configPath);
        if (is_array($config)) {
            $config[$fileVariantType->slug] = $variants;
        } else {
            $config = array();
            $config[$fileVariantType->slug] = $baseThumbConfig;
        }
        $newConfig = "<?php\nreturn " . var_export(toArray($config), true) . ";\n";
        $file = $this->file->put($configPath, $newConfig);
    }

    /**
     * @param $module_name
     * @return string
     */
    protected function getModuleThumbConfig(
        $module_name
    ) {
        $thumbConfig = base_path() . '/Modules/' . $module_name . '/Config/thumb.php';
        if ($this->file->exists($thumbConfig)) {
            return $thumbConfig;
        } else {
            throw new FileNotFoundException;
        }
    }

    private function getFileToArray($configPath)
    {
        return $this->file->getRequire($configPath);
    }

    /**
     * @param $thumb_name
     * @param $data
     * @return mixed
     */
    protected function findThumbFromThumbsList($thumb_name, $data)
    {
        if (isset($data[$thumb_name])) {
            return $data[$thumb_name];
        } else {
            Throw new FileNotFoundException;
        }
    }

    public function availables()
    {
        return $this->config->get('filemanager::config.available_thumb');
    }
}
