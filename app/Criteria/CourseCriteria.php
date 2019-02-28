<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class CourseCriteria
 * @package App\Criteria
 */
class CourseCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * CourseCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param $model
     * @param RepositoryInterface $repository
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $category_id = $this->request->get('category_id', -1);
        $model = $model->when($category_id > 0, function ($query) use ($category_id){
            return $query->where('category_id', $category_id);
        });

        $model = $model->orderBy('created_at', 'ASC');
        return $model;
    }
}