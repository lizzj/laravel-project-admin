<?php

namespace App\Repositories\Transformers\System\Sms;

use App\Models\System\Sms\Gateway;
use League\Fractal\TransformerAbstract;

/**
 * Class GatewayTransformer.
 *
 * @package namespace App\Repositories\Transformers\System\Sms;
 */
class GatewayTransformer extends TransformerAbstract
{
    /**
     * Transform the Gateway entity.
     *
     * @param \App\Models\System\Sms\Gateway $model
     *
     * @return array
     */
    public function transform(Gateway $model)
    {
        return [
            'name' => $model->name,
            'key' => $model->key,
            'secret' => $model->secret,
            'sdk_id' => $model->sdk_id,
            'status' => $model->status,
            'created_at' => $model->created_at,
        ];
    }
}
