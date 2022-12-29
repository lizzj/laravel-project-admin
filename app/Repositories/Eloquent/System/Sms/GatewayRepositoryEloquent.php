<?php

namespace App\Repositories\Eloquent\System\Sms;

use App\Models\System\Sms\Gateway;
use App\Repositories\Interfaces\System\Sms\GatewayRepository;
use App\Repositories\Presenters\System\Sms\GatewayPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class GatewayRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\System\Sms;
 */
class GatewayRepositoryEloquent extends BaseRepository implements GatewayRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Gateway::class;
    }

    public function presenter()
    {
        return app(GatewayPresenter::class);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

}
