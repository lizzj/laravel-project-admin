<?php

namespace App\Repositories\Transformers\System\Sms;

use App\Models\System\Sms\Log;
use League\Fractal\TransformerAbstract;

/**
 * Class LogTransformer.
 *
 * @package namespace App\Repositories\Transformers\System\Sms;
 */
class LogTransformer extends TransformerAbstract
{
    /**
     * Transform the Log entity.
     *
     * @param \App\Models\System\Sms\Log $model
     *
     * @return array
     */
    public function transform(Log $model)
    {
        return [
            'id' => (int)$model->id,
            'gateway' => $model->gateway,
            'scene' => $model->scene,
            'phone' => $model->phone,
            'source_ip' => $model->source_ip,
            'content' => $model->content,
            'send_at' => $model->send_at,
            'send_code' => $model->send_code,
            'send_result' => $model->send_result,
            'verify' => $model->verify,
            'template_id' => $model->template_id,
            'modules' => $model->modules,
            'created_at' => $model->created_at,
        ];
    }
}
