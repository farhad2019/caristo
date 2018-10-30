<?php

namespace App\Criteria;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class BidsHistoryForShowroomOwnerCriteria implements CriteriaInterface
{

    protected $request;

    /**
     * BidsHistroyForShowroomOwnerCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $car_ids = Auth::user()->bids()->pluck('car_id')->toArray();
        $model = $model->whereIn('id', $car_ids);

        $keyword = $this->request->get('keyword', -1);
        $model = $model->when(is_string($keyword), function ($q) use ($keyword) {
            return $q->where('name', 'LIKE', '%' . $keyword . '%');
        });

        return $model;
    }
}