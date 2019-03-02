<?php

namespace App\Criteria;

use App\Models\Category;
use App\Models\MyCar;
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

        $for_comparision = $this->request->get('for_comparision', -1);
        $model = $model->when(($for_comparision > 0), function ($brand) {
            return $brand->whereHas('carModels', function ($carModels){
                $carModels->whereHas('cars', function ($car){
                    return $car->where('category_id', MyCar::LIMITED_EDITION);
                });
            });
        });
        return $model;
    }
}