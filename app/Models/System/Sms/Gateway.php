<?php

namespace App\Models\System\Sms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gateway.
 *
 * @package namespace App\Models\System\Sms;
 */
class Gateway extends Model
{
    protected $table = 'system_sms_gateway';
    public const UPDATED_AT = null;
    protected $dateFormat = 'U';
    protected $primaryKey = 'name'; //设置主键为 name
    protected $fillable = [
        'name', 'key', 'secret', 'sdk_id', 'status'
    ];
    protected $attributes = [
        'status' => 'off'
    ];

}
