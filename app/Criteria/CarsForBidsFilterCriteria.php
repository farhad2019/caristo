<?php

namespace App\Criteria;

use App\Models\CarInteraction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

        $mostViewed = $this->request->get('most_viewed', -1);
        $model = $model->when(($mostViewed > 0), function ($query) {
            return $query->select('cars.*', DB::raw('COUNT(car_interactions.id) as views_count'))->leftJoin('car_interactions', 'car_interactions.car_id', 'cars.id')->where('car_interactions.type', CarInteraction::TYPE_VIEW)->groupBy('cars.id')->orderBy('views_count', 'DESC');
        });

        /*$model = $model->when(($mostViewed == 0), function ($query) {
            return $query->select('cars.*', DB::raw('COUNT(car_interactions.id) as views_count'))->leftJoin('car_interactions', 'car_interactions.car_id', 'cars.id')->where('car_interactions.type', CarInteraction::TYPE_VIEW)->groupBy('cars.id')->orderBy('views_count', 'Asc');
        });*/

        $category_id = $this->request->get('category_id', -1);
        $model = $model->when(($category_id > 0), function ($query) use ($category_id) {
            return $query->where('category_id', (int)$category_id);
        });

        $brand_ids = $this->request->get('brand_ids', -1);
        $model = $model->when(($brand_ids > 0), function ($query) use ($brand_ids) {
            return $query->whereHas('carModel', function ($carModel) use ($brand_ids) {
                return $carModel->whereIn('brand_id', explode(',', $brand_ids));
            });
        });

        $dealer = $this->request->get('dealer', -1);
        $model = $model->when(($dealer > 0), function ($query) use ($dealer) {
            return $query->whereHas('owner', function ($owner) use ($dealer) {
                return $owner->whereHas('details', function ($details) use ($dealer){
                    return $details->where('dealer_type', $dealer);
                });
            });
        });

        $model_ids = $this->request->get('model_ids', -1);
        $model = $model->when(($model_ids > 0), function ($query) use ($model_ids) {
            return $query->whereHas('carModel', function ($carModel) use ($model_ids) {
                return $carModel->whereIn('id', explode(',', $model_ids));
            });
        });

        $modelName = $this->request->get('model_name', '');
        $model = $model->when((strlen($modelName) > 0), function ($query) use ($modelName) {
            return $query->whereHas('carModel', function ($carModel) use ($modelName) {
                return $carModel->whereHas('translations', function ($translations) use ($modelName) {
                    return $translations->where('name', 'like', '%' . $modelName . '%');
                });
            });
        });

        $transmission_type = $this->request->get('transmission_type', -1);
        $model = $model->when(($transmission_type == 10 || $transmission_type == 20), function ($query) use ($transmission_type) {
            return $query->where('transmission_type', $transmission_type);
        });

        $car_type = $this->request->get('car_type', -1);
        $model = $model->when(($car_type > 0), function ($query) use ($car_type) {
            return $query->whereIn('type_id', explode(',', $car_type));
        });

        $max_year = $this->request->get('max_year', -1);
        $min_year = $this->request->get('min_year', -1);
        $model = $model->when(($max_year > 0 && $min_year > 0 && $max_year > $min_year), function ($query) use ($max_year, $min_year) {
            return $query->whereBetween('year', [$min_year, $max_year]);
        });

        $max_price = $this->request->get('max_price', -1);
        $min_price = $this->request->get('min_price', -1);
        $model = $model->when(($max_price > 0 && $min_price > 0 && $max_price > $min_price), function ($query) use ($max_price, $min_price) {
            return $query->whereBetween('amount', [$min_price, $max_price]);
        });

        $max_mileage = $this->request->get('max_mileage', -1);
        $min_mileage = $this->request->get('min_mileage', -1);
        $model = $model->when(($max_mileage > 0 && $min_mileage > 0 && $max_mileage > $min_mileage), function ($query) use ($max_mileage, $min_mileage) {
            return $query->whereBetween('kilometer', [$min_mileage, $max_mileage]);
        });

        $car_ids = $this->request->get('car_ids', -1);
        $model = $model->when(($car_ids > 0), function ($query) use ($car_ids) {
            return $query->whereIn('id', explode(',', $car_ids));
        });

//        $regions = $this->request->get('regions', '');
//        $model = $model->when((strlen($regions) > 0), function ($query) use ($regions) {
//            return $query->whereIn('region_id', explode(',', $regions));
//        });

       // $model = $model->orderBy('views_count', SORT_DESC);

        return $model;
    }
}