<?php

namespace App\Criteria;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class TradeInCarCriteria implements CriteriaInterface
{
    protected $request;

    /**
     * TradeInCarCriteria constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function apply($model, RepositoryInterface $repository)
    {
        $type = $this->request->get('type', -1);
        //$model = $model->where(['user_id' => Auth::id(), 'type' => $type]);
        $model = $model->when($type == 10, function ($query) use ($type) {
            return $query->where(['user_id' => Auth::id(), 'type' => $type]);
        });

        $model = $model->when($type == 20, function ($query) use ($type) {
            return $query->where(['user_id' => Auth::id(), 'type' => $type]);//->whereRaw(DB::raw('(bid_close_at < "'. now() .'")'));
        });
        /*$model = $model->whereHas('tradeAgainst', function ($tradeAgainst) {
            return $tradeAgainst->where('owner_id', Auth::id());
        });*/
//        $model = $model->where(['user_id' => Auth::id(), 'type' => $type]);
        $model = $model->orderBy('created_at', 'desc');
//        var_dump($model->toSql());
//        var_dump($model->getBindings());
//        exit();
        return $model;
    }
}