<?php
/**
 * 处理异常回调时使用
 */
if (!function_exists('endStr')) {
    function endStr($subject, $search)
    {
        return Str::of($subject)->whenContains($search, function () use ($subject, $search) {
            return Str::afterlast($subject, $search);
        }, function () {
            return false;
        });
    }
}
/**
 * 处理队列失败时的方法
 */
if (!function_exists('queueFail')) {
    function queueFail($class, $param, $e, $modules = null)
    {
        if ($param) {
            $str = Arr::query($param);
        } else {
            $str = null;
        }
        $file = ($modules ?? 'Default') . Str::afterLast($class, 'Jobs') . '/' . date('Ymd') . '.log';
        \Illuminate\Support\Facades\Storage::disk('queueError')->append($file, 'Failed--' . date('Y-m-d H:i:s') . ',Class: ' . $class . ',Message: ' . $e->getMessage() . ',File: ' . $e->getFile() . ',Line: ' . $e->getLine() . ',Param: ' . $str . ' End');
    }
}
if (!function_exists('queueRemark')) {
    function queueRemark($class, $param, $modules = null)
    {
        if ($param) {
            $str = Arr::query($param);
        } else {
            $str = null;
        }
        $file = ($modules ?? 'Default') . Str::afterLast($class, 'Jobs') . '/' . date('Ymd') . '.log';
        \Illuminate\Support\Facades\Storage::disk('queueRemark')->append($file, 'Remark--' . date('Y-m-d H:i:s') . ',Class: ' . $class . ',Param: ' . $str . ' End');
    }
}

