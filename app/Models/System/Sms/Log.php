<?php

namespace App\Models\System\Sms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Log.
 *
 * @package namespace App\Models\System\Sms;
 */
class Log extends Model
{
    protected $table = 'system_sms_log';
    public const UPDATED_AT = null;
    protected $dateFormat = 'U';
    protected $fillable = [
        'phone', 'source_ip', 'scene', 'content', 'gateway', 'template_id', 'send_at', 'send_code', 'send_result', 'verify', 'modules'
    ];
    //注释 gateway表示网关 modules表示来自的模块 scene调用的场景,source_ip来源ip template对应的模板
    protected $attributes = [
        'send_code' => 'wait',//wait-待发送,success发送成功,fail发送失败
        'verify' => 'no' //yes已验证 no未验证
    ];
    protected $casts = [
        'content' => 'array',
        'send_result' => 'array'
    ];

}
