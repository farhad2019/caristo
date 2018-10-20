<?php

namespace App\Criteria;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

        $user_id = Auth::id();

        $favorite = $this->request->get('favorite', -1);
        $model = $model->when(($favorite > 0), function ($query) use ($user_id) {
            return $query->whereHas('favorites', function ($favorites) use ($user_id) {
                return $favorites->where('user_id', $user_id);
            });
        });

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

        $max_year = $this->request->get('max_year', -1);
        $min_year = $this->request->get('min_year', -1);
        $model = $model->when(($max_year > 0 && $min_year > 0 && $max_year > $min_year), function ($query) use ($max_year, $min_year) {
            return $query->whereBetween('year', [$max_year, $min_year]);
        });

        $max_price = $this->request->get('max_price', -1);
        $min_price = $this->request->get('min_price', -1);
        $model = $model->when(($max_price > 0 && $min_price > 0 && $max_price > $min_price), function ($query) use ($max_price, $min_price) {
            return $query->whereBetween('amount', [$max_price, $min_price]);
        });

        return $model;
    }
}