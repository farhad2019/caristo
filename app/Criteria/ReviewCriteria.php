<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ReviewCriteria implements CriteriaInterface
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
        $car_id = $this->request->get('car_id', -1);

        $model = $model->when(($car_id > 0), function ($model) use ($car_id) {
            return $model->where('car_id', $car_id);
        });

        $model = $model->orderBy('created_at', 'DESC');
        return $model;
    }
}