<?php
/**
 * @note:
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/8/22 10:14
 */
/**
 * 获取最大最小值
 */
if (!function_exists('getMinMaxNum')) {
    function getMinMaxNum($num_1, $num_2, $scale, $type)
    {
        //两个数比较
        $result = bccomp($num_1, $num_2, $scale);
        if ($type === 'max') {
            //最大值
            if ($result === 1) {
                return $num_1;
            }
            return $num_2;
        }
        if ($type === 'min') {
            if ($result === 1) {
                return $num_2;
            }
            return $num_1;
        }
    }
}
/**
 * Excel 导出
 */
if (!function_exists('decimal2ABC')) {
    function decimal2ABC($num)
    {
        $ABCstr = "";
        $ten = $num - 1;
        if ($ten == 0) return "A";
        while ($ten != 0) {
            $x = $ten % 26;
            $ABCstr .= chr(65 + $x);
            $ten = intval($ten / 26);
        }
        return strrev($ABCstr);
    }
}
/**
 * Excel 导出
 */
if (!function_exists('extractNum')) {
    function extractNum($str)
    {
        $str = trim($str);
        if (empty($str)) {
            return '';
        }
        $temp = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
        $result = '';
        for ($i = 0, $iMax = strlen($str); $i < $iMax; $i++) {
            if (in_array($str[$i], $temp)) {
                $result .= $str[$i];
            }
        }
        return $result;
    }
}
/**
 * 验证是否整除
 */
if (!function_exists('isDivisible ')) {
    function isDivisible($num, $base): string
    {
        if ($num % $base === 0) {
            return true;
        }
        return false;
    }
}
/**
 * 随机指定长度的数字
 */
if (!function_exists('random_length')) {
    function random_length($length)
    {
        if ($length <= 0) {
            return $length;
        }
        return random_int(10 ** ($length - 1), (10 ** $length) - 1);
    }
}
/**
 * 获取随机数
 */
if (!function_exists('getRandNum')) {
    function getRandNum($array)
    {
        $result = '';
        //概率数组的总概率精度
        $proSum = array_sum($array);
        //概率数组循环
        foreach ($array as $key => $proCur) {
            $randNum = random_int(1, $proSum);             //抽取随机数
            if ($randNum <= $proCur) {
                $result = $key;                         //得出结果
                break;
            }
            $proSum -= $proCur;
        }
        return $result;
    }
}
/**
 * 获取随机概率
 */
if (!function_exists('getRandProbability')) {
    function getRandProbability($num, $base_num)
    {
        if ($num <= 0) {
            return false;
        }
        $init = random_int(0, $base_num);
        if ($init < $num) {
            return true;
        }
        return false;
    }
}
