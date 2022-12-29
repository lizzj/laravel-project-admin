<?php

namespace App\Repositories\Transformers\Auth\Mall\Admin;

use League\Fractal\TransformerAbstract;
use App\Models\Auth\Mall\Admin\Admin;

/**
 * Class AdminTransformer.
 *
 * @package namespace App\Repositories\Transformers\Auth\Mall\Admin;
 */
class AdminTransformer extends TransformerAbstract
{
    /**
     * Transform the Admin entity.
     *
     * @param \App\Models\Auth\Mall\Admin\Admin $model
     *
     * @return array
     */
    public function transform(Admin $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
