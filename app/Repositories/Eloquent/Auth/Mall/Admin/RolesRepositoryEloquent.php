<?php

namespace App\Repositories\Eloquent\Auth\Mall\Admin;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\Interfaces\Auth\Mall\Admin\RolesRepository;
use App\Models\Auth\Mall\Admin\Roles;
use App\Validators\Auth\Mall\Admin\RolesValidator;

/**
 * Class RolesRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\Auth\Mall\Admin;
 */
class RolesRepositoryEloquent extends BaseRepository implements RolesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Roles::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
