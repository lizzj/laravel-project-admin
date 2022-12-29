<?php

namespace App\Repositories\Presenters\Auth\Client\Mall;

use App\Repositories\Transformers\Auth\Client\Mall\OauthTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OauthPresenter.
 *
 * @package namespace App\Repositories\Presenters\Auth\Client\Mall;
 */
class OauthPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OauthTransformer();
    }
}
