<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class NewsCriteria implements CriteriaInterface
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
        
        if ($category_id >= 0) {
            $model = $model->where('category_id', $category_id);
        }

        $model = $model->orderBy('created_at', SORT_DESC);

        return $model;
    }

}