<?php
/**
 * @note:
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:03
 */
/**
 * 检测手机端
 */
if (!function_exists('isMobile')) {
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE'])) {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA'])) {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT'])) {
            $clientkeywords = array('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT'])) {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
                return true;
            }
        }
        return false;
    }
}
/**
 * 获取访问ip
 */
if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        static $ip = '';
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_CDN_SRC_IP'])) {
            $ip = $_SERVER['HTTP_CDN_SRC_IP'];
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']) and preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        }
        return $ip;
    }
}
/**
 * 栏目递归
 */
if (!function_exists('processCategory')) {
    function processCategory($cates, $pid)
    {
        $data = [];
        foreach ($cates as $k => $v) {
            if ($v->pid == $pid) {
                $v->children = processCategory($cates, $v->id);
                $data[] = $v;
            }
        }
        return $data;
    }
}
/**
 * 栏目递归
 */
if (!function_exists('processEcharts')) {
    function processEcharts($item, $pid)
    {
        $data = [];
        foreach ($item as $k => $v) {
            if ((int)$v->code_no === 0) {
                $h_code = $v->id;
            } else {
                $h_code = $v->code_no . '.' . $v->id;
            }
            if ($v->code_no == $h_code) {
                $v->children = processCategory($item, $v->h_code);
                $data[] = $v;
            }
        }
        return $data;
    }
}
/**
 * 过滤表情
 */
if (!function_exists('filterEmoji')) {
    function filterEmoji($str)
    {
        $str = preg_replace_callback(
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
        return $str;
    }
}
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

