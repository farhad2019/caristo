<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CarTypeCriteria
 * @package App\Http\Controllers\Api
 */
class CarTypeCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * CarTypeCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $parent_id = $this->request->get('parent_id', -1);
        $depends = $this->request->get('depends', -1);

        if ($parent_id >= 0) {
            $model = $model->where('parent_id', $parent_id);
        }

        if ($depends >= 0) {
            $model = $model->where('parent_id', $depends);
        }

        $model = $model->orderBy('created_at', 'ASC');
        return $model;
    }
}