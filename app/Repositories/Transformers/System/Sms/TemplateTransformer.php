<?php

namespace App\Repositories\Transformers\System\Sms;

use App\Models\System\Sms\Template;
use League\Fractal\TransformerAbstract;

/**
 * Class TemplateTransformer.
 *
 * @package namespace App\Repositories\Transformers\System\Sms;
 */
class TemplateTransformer extends TransformerAbstract
{
    /**
     * Transform the Template entity.
     *
     * @param \App\Models\System\Sms\Template $model
     *
     * @return array
     */
    public function transform(Template $model)
    {
        return [
            'id' => (int)$model->id,
            'gateway' => $model->gateway,
            'type' => $model->type,
            'call_code' => $model->call_code,
            'call_name' => $model->call_name,
            'template_no' => $model->template_no,
            'template_sign' => $model->template_sign,
            'param' => $model->param,
            'modules' => $model->modules,
            'created_at' => $model->created_at,
        ];
    }
}
