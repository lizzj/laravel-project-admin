<?php
/**
 * @note:
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:03
 */
/**
 * 图片Base64保存
 */
if (!function_exists('imageBase64')) {
    /**
     * @throws Exception
     */
    function imageBase64($image_info, $path, $name = null)
    {
        try {
            if (!$name) {
                $name = date("His") . random_length(6) . ".png";
            }
            $file_name = $path . $name;
            \Intervention\Image\Facades\Image::make($image_info)->save($file_name);
            return $file_name;
        } catch (\Exception $e) {
            return false;
        }
    }
}
/**
 * 图片下载保存
 */
if (!function_exists('imageDownload')) {
    function imageDownload($url)
    {
        (string)$url = Str::of($url)->whenEndsWith('.webp', function ($string) {
            return $string->beforeLast('!');
        });
        try {
            $image = \Intervention\Image\Facades\Image::make($url);
            $path = fileSave('ModulesStatic/Download');
            $mime = Str::afterLast($image->mime(), 'image/');
            $full_path = $path . date("His") . random_length(6) . "." . $mime;
            $image->save($full_path);
            return $full_path;
        } catch (\Exception $e) {
            return false;
        }
    }
}
