<?php

namespace App\Repositories\Eloquent\Auth\Mall\Admin;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Auth\Mall\Admin\AdminRepository;
use App\Models\Auth\Mall\Admin\Admin;
use App\Validators\Auth\Mall\Admin\AdminValidator;

/**
 * Class AdminRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\Auth\Mall\Admin;
 */
class AdminRepositoryEloquent extends BaseRepository implements AdminRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Admin::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
