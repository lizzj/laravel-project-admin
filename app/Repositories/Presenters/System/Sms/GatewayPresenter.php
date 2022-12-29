<?php

namespace App\Repositories\Presenters\System\Sms;

use App\Repositories\Transformers\System\Sms\GatewayTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class GatewayPresenter.
 *
 * @package namespace App\Repositories\Presenters\System\Sms;
 */
class GatewayPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new GatewayTransformer();
    }
}
