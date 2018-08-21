<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class UnreadNewsCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        // Implement apply() method.
        $category_id = $this->request->get('category_id', -1);
        $model = $model->whereDoesntHave('views', function ($query) {
            return $query->where('user_id', \Auth::id());
        });

        if ($category_id >= 0) {
            $model = $model->where('category_id', $category_id);
        }

        return $model;
    }

}