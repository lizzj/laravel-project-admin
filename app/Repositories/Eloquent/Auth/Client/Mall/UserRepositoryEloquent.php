<?php

namespace App\Repositories\Eloquent\Auth\Client\Mall;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Auth\Client\Mall\UserRepository;
use App\Models\Auth\Client\Mall\User;
use App\Validators\Auth\Client\Mall\UserValidator;

/**
 * Class UserRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\Auth\Client\Mall;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
