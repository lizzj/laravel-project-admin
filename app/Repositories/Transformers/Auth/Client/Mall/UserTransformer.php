<?php

namespace App\Repositories\Transformers\Auth\Client\Mall;

use League\Fractal\TransformerAbstract;
use App\Models\Auth\Client\Mall\User;

/**
 * Class UserTransformer.
 *
 * @package namespace App\Repositories\Transformers\Auth\Client\Mall;
 */
class UserTransformer extends TransformerAbstract
{
    /**
     * Transform the User entity.
     *
     * @param \App\Models\Auth\Client\Mall\User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
