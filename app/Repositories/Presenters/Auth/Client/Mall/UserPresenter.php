<?php

namespace App\Repositories\Presenters\Auth\Client\Mall;

use App\Repositories\Transformers\Auth\Client\Mall\UserTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class UserPresenter.
 *
 * @package namespace App\Repositories\Presenters\Auth\Client\Mall;
 */
class UserPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new UserTransformer();
    }
}
