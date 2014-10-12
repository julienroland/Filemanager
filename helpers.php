<?php
if (!function_exists('upload_dir')) {

    function upload_dir($dir)
    {
        return '/' . Config::get('filemanager::config.folder_dir') . '/' . $dir;
    }
}