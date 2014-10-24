<?php
if (!function_exists('upload_dir')) {

    function upload_dir($dir)
    {
        return '/' . Config::get('filemanager::config.folder_dir') . '/' . $dir;
    }
}

if (!function_exists('array_filter_recursive')) {
    function array_filter_recursive($input)
    {
        foreach ($input as &$value) {
            if (is_array($value)) {
                $value = array_filter_recursive($value);
            }
        }
        return array_filter($input);
    }
}
if (!function_exists('toArray')) {
    function toArray($obj)
    {
        foreach ($obj as &$value) {
            if (is_object($value)) {
                $value = toArray($value);
            }
        }
        if (is_object($obj)) {
            return get_object_vars($obj);
        } else {
            return $obj;
        }
    }
}
