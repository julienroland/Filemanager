<?php  namespace Modules\Filemanager\Thumb;

use Illuminate\Support\Facades\File;
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
        $configPath = base_path() . '/Modules/Filemanager/Config/Config.php';
        $configdd = array('Thumb' => array('test-tumb' => array('width' => 300, 'height' => 200)));
        $test = $this->file->get($configPath);
        dd(pathinfo($test));
        $test2 = "<?php\n\n return  ?>" . var_export($test . $configdd, true) . ";\n";
        $test = $this->file->put($test2);
        dd($test);
        foreach ($modules as $module) {
            $configPath = public_path() . '/Modules/' . $module . '/Config/Config.php';
            if (!File::exists($configPath)) {
                //var_export
                $test = fwrite($configPath, 'text');
                dd($test);
                File::put($configPath, '<?php return array("ttest")');
            }
        }

        return $modules;
    }
}
