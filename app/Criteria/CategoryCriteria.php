<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class CategoryCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $parent_id = $this->request->get('parent_id', -1);

        if ($parent_id >= 0) {
            $model = $model->where('parent_id', $parent_id);
        }

        $model = $model->orderBy('created_at', 'ASC');
        return $model;
    }

}