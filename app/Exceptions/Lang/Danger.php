<?php
/**
 * @note: 定义系统错误
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:08
 */

namespace App\Exceptions\Lang;
class Danger
{
    public static function Init($code)
    {
        $codes = static::getCodes();
        return [
            'code' => $codes[$code] ?? 40001,
            'message' => 'Error',
        ];
    }

    public static function getCodes(): array
    {
        return [
            'QueryException' => 40002,
            'ModelNotFoundException' => 40003,
            'NotFoundHttpException' => 40004,
            'BindingResolutionException' => 40001,
            'ParameterException' => 40005,
            'BadMethodCallException' => 40006,
            'InvalidArgumentException' => 40007,
            'HttpException' => 40008,
        ];
    }
}
