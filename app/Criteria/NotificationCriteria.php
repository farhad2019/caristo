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
        $user_id = Auth::id();
        $model = $model->whereHas('users', function ($notificationUser) use ($user_id) {
            return $notificationUser->where('user_id', $user_id);
        })->orderBy('created_at', 'ASC');

        return $model;
    }

}