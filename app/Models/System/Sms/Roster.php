<?php

namespace App\Models\System\Sms;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Roster.
 *
 * @package namespace App\Models\System\Sms;
 */
class Roster extends Model
{
    use SoftDeletes;

    protected $table = 'system_sms_roster';
    public const UPDATED_AT = null;
    protected $dateFormat = 'U';
    protected $fillable = [
        'phone', 'remark', 'modules', 'type'
    ];

}
