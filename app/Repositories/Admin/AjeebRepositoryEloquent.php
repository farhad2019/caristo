<?php

namespace App\Repositories\Admin;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\admin\ajeebRepository;
use App\Entities\Admin\Ajeeb;
use App\Validators\Admin\AjeebValidator;

/**
 * Class AjeebRepositoryEloquent.
 *
 * @package namespace App\Repositories\Admin;
 */
class AjeebRepositoryEloquent extends BaseRepository implements AjeebRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Ajeeb::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
