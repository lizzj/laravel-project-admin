<?php

namespace App\Repositories\Eloquent\System\Sms;

use App\Models\System\Sms\Config;
use App\Repositories\Interfaces\System\Sms\ConfigRepository;
use App\Repositories\Presenters\System\Sms\ConfigPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class ConfigRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\System\Sms;
 */
class ConfigRepositoryEloquent extends BaseRepository implements ConfigRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Config::class;
    }

    public function presenter()
    {
        return app(ConfigPresenter::class);
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

}
