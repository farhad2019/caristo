<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CarModelFilterCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * CarModelFilterCriteria constructor.
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
        $brand_id = $this->request->get('brand_id', -1);
        $name = $this->request->get('name', '');
        $depends = $this->request->get('depends', -1);
        $for_comparision = $this->request->get('for_comparision', -1);

        $model = $model->when(($brand_id > 0 || $depends > 0), function ($model) use ($depends, $brand_id) {
            return $model->whereIn('brand_id', [$depends, $brand_id]);
        });

        $model = $model->when(($brand_id > 0 && $for_comparision > 0), function ($model) use ($for_comparision, $brand_id) {
            return $model->whereIn('brand_id', [$brand_id])->whereHas('cars');
        });

        $model = $model->when((!empty($name)), function ($model) use ($name) {
            return $model->whereHas('translations', function ($trans) use ($name) {
                return $trans->where('name', 'like', '%' . $name . '%');
            });
        });
        return $model;
    }
}