<?php

namespace App\Repositories\Eloquent\Auth\Client\Mall;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Auth\Client\Mall\OauthRepository;
use App\Models\Auth\Client\Mall\Oauth;
use App\Validators\Auth\Client\Mall\OauthValidator;

/**
 * Class OauthRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\Auth\Client\Mall;
 */
class OauthRepositoryEloquent extends BaseRepository implements OauthRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Oauth::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
