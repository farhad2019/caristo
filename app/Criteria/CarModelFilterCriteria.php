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

        if ($brand_id > 0) {
            $model = $model->where('brand_id', $brand_id);
        }
        return $model;
    }

}