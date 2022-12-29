<?php
/**
 * 处理数组,删除空的值
 */
if (!function_exists('arrayDetail')) {
    function arrayDetail($array)
    {
        foreach ($array as $key => $value) {
            if (empty($value)) {
                unset($array[$key]);
            }
            if (is_string($value) && empty(trim($value))) {
                unset($array[$key]);
            }
            if (is_bool($value)) {
                unset($array[$key]);
            }
        }
        return $array;
    }
}
/**
 * 一维数组转二维数组
 */
if (!function_exists('arrayObject')) {
    /**
     * @throws JsonException
     */
    function arrayObject($array, $new_key, $new_value): array
    {
        $result = [];
        //过滤完之后,还需要is_string判断
        if (is_string(trim($new_key)) && is_string(trim($new_value)) && filled(trim($new_key)) && filled(trim($new_value))) {
            if (!empty($array)) {
                $array = json_decode(json_encode($array, JSON_THROW_ON_ERROR), true, 512, JSON_THROW_ON_ERROR);
                $keys_arr = array_keys($array);
                $values_arr = array_values($array);
                for ($i = 0, $iMax = count($array); $i < $iMax; $i++) {
                    $result[$i][$new_key] = $keys_arr[$i];
                    $result[$i][$new_value] = $values_arr[$i];
                }
            }
        }
        return $result;
    }
}

/**
 * 数组转对象
 */
if (!function_exists('objectArray')) {
    function objectArray($object): array
    {
        $result = [];
        $_array = is_object($object) ? get_object_vars($object) : $object;
        foreach ($_array as $key => $value) {
            $value = (is_array($value) || is_object($value)) ? objectArray($value) : $value;
            $result[$key] = $value;
        }
        return $result;
    }
}
//判断是否在区间
if (!function_exists('arrayBetween')) {
    function arrayBetween($min, $max, $value): bool
    {
        return $value >= $min && $value <= $max;
    }
}
//随机取值
if (!function_exists('arrayRandom')) {
    function arrayRandom($num)
    {
        $array = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 'A', 'B', 'C', 'D', 'E', 'F'];
        $str = '';
        for ($i = 0; $i < $num; $i++) {
            $str .= $array[random_int(0, count($array) - 1)];
        }
        return $str;
    }
}

