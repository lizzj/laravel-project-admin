<?php

namespace App\Models\System\Sms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Template.
 *
 * @package namespace App\Models\System\Sms;
 */
class Template extends Model
{
    protected $table = 'system_sms_template';
    public const UPDATED_AT = null;
    protected $dateFormat = 'U';
    protected $fillable = [
        'gateway', 'type', 'call_code', 'call_name', 'template_no', 'template_sign', 'param', 'modules', 'status'
    ];
    protected $attributes = [
        'status' => 'on'
    ];
    //type类型  code验证码类  market营销类 notice通知类
    protected $casts = [
        'param' => 'array'
    ];
}
