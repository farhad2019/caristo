<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class ChapterCriteria
 * @package App\Criteria
 */
class ChapterCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * ChapterCriteria constructor.
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
        $course_id = $this->request->get('course_id', -1);
        $model = $model->when($course_id > 0, function ($query) use ($course_id) {
            return $query->where('course_id', $course_id);
        });

        $model = $model->orderBy('created_at', 'ASC');
        return $model;
    }
}