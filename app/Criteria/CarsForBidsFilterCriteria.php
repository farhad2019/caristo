<?php

namespace App\Criteria;

use App\Models\User;
use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CarsForBidsFilterCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->where('owner_type', User::SHOWROOM_OWNER);

        $category_id = $this->request->get('category_id', -1);
        $model = $model->when(($category_id > 0), function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        });

        $brand_ids = $this->request->get('brand_ids', -1);
        $model = $model->when(($brand_ids > 0), function ($query) use ($brand_ids) {
            return $query->whereHas('carModel', function ($carModel) use ($brand_ids) {
                return $carModel->whereIn('brand_id', explode(',', $brand_ids));
            });
        });

        $transmission_type = $this->request->get('transmission_type', -1);
        $model = $model->when(($transmission_type == 10 || $transmission_type == 20), function ($query) use ($transmission_type) {
            return $query->where('transmission_type', $transmission_type);
        });

        $car_type = $this->request->get('car_type', -1);
        $model = $model->when(($car_type > 0), function ($query) use ($car_type) {
            return $query->where('type_id', $car_type);
        });

        return $model;
    }
}