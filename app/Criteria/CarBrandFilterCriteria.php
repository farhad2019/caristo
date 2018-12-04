<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CarBrandFilterCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * CarBrandFilterCriteria constructor.
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
        $name = $this->request->get('name', '');

        $model = $model->when((!empty($name)), function ($model) use ($name) {
            return $model->whereHas('translations', function ($trans) use ($name) {
                return $trans->where('name', 'like', '%' . $name . '%');
            });
        });

        return $model;
    }
}