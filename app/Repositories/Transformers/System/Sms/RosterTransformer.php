<?php

namespace App\Repositories\Transformers\System\Sms;

use App\Models\System\Sms\Roster;
use League\Fractal\TransformerAbstract;

/**
 * Class RosterTransformer.
 *
 * @package namespace App\Repositories\Transformers\System\Sms;
 */
class RosterTransformer extends TransformerAbstract
{
    /**
     * Transform the Roster entity.
     *
     * @param \App\Models\System\Sms\Roster $model
     *
     * @return array
     */
    public function transform(Roster $model)
    {
        return [
            'id' => (int)$model->id,
            'phone' => $model->phone,
            'remark' => $model->remark,
            'modules' => $model->modules,
            'type' => $model->type,
            /* place your other model properties here */
            'created_at' => $model->created_at,
        ];
    }
}
