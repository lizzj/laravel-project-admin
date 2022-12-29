<?php
/**
 * @note:定义提示--提示类事件
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:09
 */

namespace App\Exceptions\Lang;
class Notice
{
    public static function Code($code)
    {
        $maps = static::Msg();
        return $maps[$code] ?? '提示信息';
    }

    public static function Msg()
    {
        return [
            '50002' => '系统维护....',

        ];
    }
}
