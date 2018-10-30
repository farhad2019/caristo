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

        return $model;
    }
}