<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CarsFilterCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $user = Auth::user();
        $model = $model->where('owner_id', $user->id);

        /*$ownerType = $this->request->get('ownerType', -1);

        $model = $model->when($ownerType == 10 || $ownerType == 20, function ($query) use ($ownerType) {
            return $query->where('owner_type', $ownerType);
        });*/

        return $model;
    }
}