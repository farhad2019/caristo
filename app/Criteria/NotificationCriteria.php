<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class NotificationCriteria implements CriteriaInterface
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        // Implement apply() method.
        $model = $model->whereHas('users', function ($notificationUser) {
            return $notificationUser->where('user_id', Auth::id());
        })->orderBy('created_at', 'DESC');
        var_dump($model->toSql());
        exit();
        return $model;
    }
}