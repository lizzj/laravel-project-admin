<?php

namespace App\Repositories\Transformers\System\Sms;

use App\Models\System\Sms\Config;
use League\Fractal\TransformerAbstract;

/**
 * Class ConfigTransformer.
 *
 * @package namespace App\Repositories\Transformers\System\Sms;
 */
class ConfigTransformer extends TransformerAbstract
{
    /**
     * Transform the Config entity.
     *
     * @param \App\Models\System\Sms\Config $model
     *
     * @return array
     */
    public function transform(Config $model)
    {
        return [
            'id' => (int)$model->id,
            'default' => $model->default,
            'throttle_minute' => (int)$model->throttle_minute,
            'throttle_hour' => (int)$model->throttle_hour,
            'throttle_day' => (int)$model->throttle_day,
            'throttle_ip' => (int)$model->throttle_ip,
            'verify' => (int)$model->verify,
            'created_at' => $model->created_at,
        ];
    }
}
