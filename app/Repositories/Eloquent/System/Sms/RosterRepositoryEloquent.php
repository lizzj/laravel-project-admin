<?php

namespace App\Repositories\Eloquent\System\Sms;

use App\Models\System\Sms\Roster;
use App\Repositories\Interfaces\System\Sms\RosterRepository;
use App\Repositories\Presenters\System\Sms\RosterPresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class RosterRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\System\Sms;
 */
class RosterRepositoryEloquent extends BaseRepository implements RosterRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Roster::class;
    }

    public function presenter()
    {
        return app(RosterPresenter::class);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

    public function verifyPhone($phone, $modules)
    {
        $result = Roster::where(['phone' => $phone, 'modules' => $modules])->first();
        if ($result) {
            //证明存在--白名单
            if ($result->type === 'white') {
                return ['status' => 'success'];
            }
            return ['status' => 'fail', 'code' => 61011];
        }
        return false;
    }

}
