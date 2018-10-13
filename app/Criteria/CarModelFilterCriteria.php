<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CarModelFilterCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        // Implement apply() method.
        $brand_id = $this->request->get('brand_id', -1);
        $depends = $this->request->get('depends', -1);

        $model = $model->when(($brand_id > 0 || $depends > 0), function ($model) use ($depends, $brand_id) {
            return $model->whereIn('brand_id', [$depends, $brand_id]);
        });

        return $model;
    }

}