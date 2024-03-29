<?php
/**
 * @note: 定义成功事件
 * @return ${TYPE_HINT}
 * @author:Je_taime
 * @time: 2022/3/24 9:08
 */

namespace App\Exceptions\Lang;

class Success
{
    public static function Code($code)
    {
        $maps = static::Msg();
        return $maps[$code] ?? '请求成功';
    }

    public static function Msg()
    {
        return [
            '20000' => '请求成功',
            '20001' => '创建成功',
            '20002' => '修改成功',
            '20003' => '删除成功',
            '20004' => '上传成功',

            '20005' => '处理成功',
            '20006' => '申请成功',
            '20007' => '购买成功',
            '20008' => '退出成功',
            '20009' => '转账成功',
            '20010' => '短信已发送,请注意查收',
            '20011' => '充值成功',
            '20012' => '交易成功',
            '20013' => '请求成功',
            '21001' => '新增任务成功',
            '21002' => '重新提交成功',
            '21003' => '当前级别已为最高级别',
            '22001' => '存在新版本',
            //Auth部分
            '29995' => '创建成功',
            '29996' => '重置密码成功',
            '29997' => '授权成功',
            '29998' => '注册成功',
            '29999' => '登录成功'
        ];
    }
}
