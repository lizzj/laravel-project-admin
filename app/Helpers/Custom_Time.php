<?php

use Carbon\Carbon;

/**
 * 获取13位毫秒级时间戳
 */
if (!function_exists('timeUnix')) {
    function timeUnix($length = null): float
    {
        return Carbon::now()->getPreciseTimestamp($length);
    }
}
/**
 * 获取昨天开始结束的时间戳
 */
if (!function_exists('timeYesterday')) {
    function timeYesterday()
    {
        return [Carbon::yesterday()->startOfDay()->timestamp, Carbon::yesterday()->endOfDay()->timestamp];
    }
}
/**
 * 获取上周开始结束的时间戳
 */
if (!function_exists('timeLastWeek')) {
    function timeLastWeek()
    {
        return [Carbon::now()->startOfWeek()->subWeek()->timestamp, Carbon::now()->startOfWeek()->subWeek()->endOfWeek()->timestamp];
    }
}
/**
 * 获取上月开始结束的时间戳
 */
if (!function_exists('timeLastMonth')) {
    function timeLastMonth()
    {
        return [Carbon::now()->startOfMonth()->subMonth()->timestamp, Carbon::now()->startOfMonth()->subMonth()->endOfMonth()->timestamp];
    }
}
/**
 * 获取去年开始结束的时间戳
 */
if (!function_exists('timeLastYear')) {
    function timeLastYear()
    {
        return [Carbon::now()->startOfYear()->subYear()->timestamp, Carbon::now()->startOfYear()->subYear()->endOfYear()->timestamp];
    }
}
/**
 * 获取今天开始结束的时间戳
 */
if (!function_exists('timeToday')) {
    function timeToday()
    {
        return [Carbon::now()->startOfDay()->timestamp, Carbon::now()->endOfDay()->timestamp];
    }
}
/**
 * 获取本周开始和结束的时间戳
 */
if (!function_exists('timeCurrentWeek')) {
    function timeCurrentWeek()
    {
        return [Carbon::now()->startOfWeek()->timestamp, Carbon::now()->endOfWeek()->timestamp];
    }
}
/**
 * 获取当月开始和结束的时间戳
 */
if (!function_exists('timeCurrentMonth')) {
    function timeCurrentMonth()
    {
        return [Carbon::now()->startOfMonth()->timestamp, Carbon::now()->endOfMonth()->timestamp];
    }
}
/**
 * 获取今年开始和结束的时间戳
 */
if (!function_exists('timeCurrentYear')) {
    function timeCurrentYear()
    {
        return [Carbon::now()->startOfYear()->timestamp, Carbon::now()->endOfYear()->timestamp];
    }
}
/**
 * 未来的几天,几周,几月,几年 next
 */
if (!function_exists('timePassDay')) {
    function timePassDay($length = null)
    {
        return [Carbon::now()->subDays($length)->timestamp, Carbon::now()->timestamp];
    }
}
/**
 * 前几天,几周,几月,几年 last
 */
//if (!function_exists('timeLastFew')) {
//    function timeLastFew($type, $start_time = null, $end_time = null)
//    {
//
//    }
//}
/**
 * 前几天,几周,几月,几年 last
 */
//if (!function_exists('timeNextFew')) {
//    function timeNextFew($type, $start_time = null, $end_time = null)
//    {
//
//    }
//}
