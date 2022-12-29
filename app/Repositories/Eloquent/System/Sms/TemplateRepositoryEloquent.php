<?php

namespace App\Repositories\Eloquent\System\Sms;

use App\Models\System\Sms\Template;
use App\Repositories\Interfaces\System\Sms\TemplateRepository;
use App\Repositories\Presenters\System\Sms\TemplatePresenter;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class TemplateRepositoryEloquent.
 *
 * @package namespace App\Repositories\Eloquent\System\Sms;
 */
class TemplateRepositoryEloquent extends BaseRepository implements TemplateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Template::class;
    }

    public function presenter()
    {
        return app(TemplatePresenter::class);
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {

    }

    public function getTemplate($gateway, $type, $modules)
    {
        if ($result = Template::where(['gateway' => $gateway, 'type' => $type, 'modules' => $modules, 'status' => 'on'])->first()) {
            return $this->find($result->id)['data'];
        }
        return false;
    }

}
