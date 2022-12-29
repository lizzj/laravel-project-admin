<?php

namespace App\Models\System\Sms;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Config.
 *
 * @package namespace App\Models\System\Sms;
 */
class Config extends Model
{
    protected $table = 'system_sms_config';
    public const UPDATED_AT = null;
    protected $dateFormat = 'U';
    protected $fillable = [
        'default', 'throttle_minute', 'throttle_hour', 'throttle_day', 'throttle_ip', 'verify'
    ];

}
