<?php

namespace App\Repositories\Transformers\Auth\Mall\Admin;

use League\Fractal\TransformerAbstract;
use App\Models\Auth\Mall\Admin\Roles;

/**
 * Class RolesTransformer.
 *
 * @package namespace App\Repositories\Transformers\Auth\Mall\Admin;
 */
class RolesTransformer extends TransformerAbstract
{
    /**
     * Transform the Roles entity.
     *
     * @param \App\Models\Auth\Mall\Admin\Roles $model
     *
     * @return array
     */
    public function transform(Roles $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
