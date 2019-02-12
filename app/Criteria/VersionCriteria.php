<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class VersionCriteria
 * @package App\Http\Controllers\Api
 */
class VersionCriteria implements CriteriaInterface
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * VersionCriteria constructor.
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
        $model_id = $this->request->get('model_id', -1);
        $name = $this->request->get('name', '');
        $depends = $this->request->get('depends', -1);

        $model = $model->when(($model_id > 0 || $depends > 0), function ($model) use ($depends, $model_id) {
            return $model->whereIn('model_id', [(int)$depends, (int)$model_id]);
        });

        $model = $model->when((!empty($name)), function ($model) use ($name) {
            return $model->where('name', 'like', '%' . $name . '%');
        });

        return $model;
    }
}