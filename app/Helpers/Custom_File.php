<?php
/**
 * @note:
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:03
 */

use Illuminate\Support\Facades\File;

if (!function_exists('fileSave')) {
    function fileSave($path)
    {
        $savePath = $path . '/' . date("Ymd") . '/';
        File::isDirectory($savePath) or File::makeDirectory($savePath, 0777, true, true);
        return $savePath;
    }
}
