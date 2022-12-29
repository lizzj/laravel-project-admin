<?php

namespace App\Repositories\Transformers\Auth\Client\Mall;

use League\Fractal\TransformerAbstract;
use App\Models\Auth\Client\Mall\Oauth;

/**
 * Class OauthTransformer.
 *
 * @package namespace App\Repositories\Transformers\Auth\Client\Mall;
 */
class OauthTransformer extends TransformerAbstract
{
    /**
     * Transform the Oauth entity.
     *
     * @param \App\Models\Auth\Client\Mall\Oauth $model
     *
     * @return array
     */
    public function transform(Oauth $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
