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

        $category_id = $this->request->get('category_id', -1);

        $model = $model->when(($category_id > 0), function ($query) use ($category_id) {
            return $query->where('category_id', $category_id);
        });

        $model = $model->orderBy('created_at', 'desc');
        return $model;
    }
}