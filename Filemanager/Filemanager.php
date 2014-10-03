<?php  namespace Modules\Filemanager\Filemanager;

use Illuminate\Support\Facades\Config;

class Filemanager
{
    public function upload()
    {
        return $this->input();
    }

    private function input()
    {
        return $this->fileOutput();
    }

    private function fileOutput()
    {
        echo '<input type="file" name="' . Config::get('filemanager::config.file_name') . '" id=""/>';
    }
}