<?php  namespace Modules\Filemanager\Thumb;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;
use Modules\Filemanager\Filemanager\File\Filesystem;
use Pingpong\Modules\Facades\Module;

class Thumb
{
    /**
     * @var Filesystem
     */
    private $file;

    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }

    public function get()
    {
        $modules = Module::all();
        $thumbs = [];
        foreach ($modules as $module) {
            $configPath = base_path() . '/Modules/' . $module . '/Config/thumb.php';
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
        $thumbKey = Config::get('filemanager::config.thumb_config_key');

        foreach ($modules as $module) {
            $configPath = base_path() . '/Modules/' . $module . '/Config/config.php';
            if ($this->file->exists($configPath)) {
                $baseThumbConfig = array('Thumb' => array());
                $config = new Collection($this->file->getRequire($configPath));
                if (isset($config[$thumbKey])) {
                    $config->forget($thumbKey);
                }
                /* $config->put($thumbKey,
                     $baseThumbConfig[$thumbKey]);*/
                $newConfig = "<?php\nreturn " . var_export($config->toArray(), true) . ";\n";
                $test = $this->file->put($configPath, $newConfig);
            }
        }
    }

    private function addOrEditConfigFile($module, $fileVariantType)
    {
        $variants = toArray(json_decode($fileVariantType->value));
        $thumbKey = Config::get('filemanager::config.thumb_config_key');
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
}
