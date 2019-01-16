<?php

namespace App\Repositories\Admin;

use App\Models\TradeInCar;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use InfyOm\Generator\Common\BaseRepository;
use function MongoDB\BSON\toJSON;

/**
 * Class TradeInCarRepository
 * @package App\Repositories\Admin
 * @version December 18, 2018, 11:09 am UTC
 *
 * @method TradeInCar findWithoutFail($id, $columns = ['*'])
 * @method TradeInCar find($id, $columns = ['*'])
 * @method TradeInCar first($columns = ['*'])
 */
class TradeInCarRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'owner_car_id',
        'customer_car_id',
        'user_id',
        'amount',
        'notes'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return TradeInCar::class;
    }

    /**
     * @param bool $hasBid
     * @param array $search
     * @param int $status
     * @return mixed
     */
    public function getTradeInCars($hasBid = false, $search = [], $status = 0)
    {
        $cars = Auth::user()->cars->count() > 0 ? implode(",", Auth::user()->cars()->pluck('id')->toArray()) : 0;
        return $this->model
            ->when(($hasBid), function ($q) use ($cars) {
                return $q->whereRaw(DB::raw('CASE
    WHEN trade_in_cars.type = ' . TradeInCar::TRADE_IN . '  
    THEN amount IS NOT NULL AND `owner_car_id` IN (' . $cars . ')
    WHEN trade_in_cars.type = ' . TradeInCar::EVALUATE_CAR . '  
    THEN `owner_car_id` IS NULL AND EXISTS 
    (SELECT 
      * 
    FROM
      `car_evaluation_bids` 
    WHERE `trade_in_cars`.`id` = `car_evaluation_bids`.`evaluation_id` 
      AND `user_id` = ' . Auth::id() . '  
      AND `car_evaluation_bids`.`deleted_at` IS NULL) 
  END'));
                /*->whereRaw(DB::raw('amount IS NOT NULL'))
                ->whereHas('evaluationDetails', function ($qq) {
                    return $qq->where('user_id', Auth::id());
                });*/
            })
            ->when((!$hasBid), function ($q) use ($cars) {
                return $q->whereRaw(DB::raw('CASE
    WHEN trade_in_cars.type = ' . TradeInCar::TRADE_IN . '  
    THEN amount IS NULL AND `owner_car_id` IN (' . $cars . ')
    WHEN trade_in_cars.type = ' . TradeInCar::EVALUATE_CAR . '  
    THEN `owner_car_id` IS NULL AND NOT EXISTS 
    (SELECT 
      * 
    FROM
      `car_evaluation_bids` 
    WHERE `trade_in_cars`.`id` = `car_evaluation_bids`.`evaluation_id` 
      AND `user_id` = ' . Auth::id() . '  
      AND `car_evaluation_bids`.`deleted_at` IS NULL) 
  END'));
                /*return $q->whereRaw(DB::raw('amount IS NULL'))
                    ->whereDoesntHave('evaluationDetails', function ($qq) {
                        return $qq->where('user_id', Auth::id());
                    });
                ->whereRaw(DB::raw('(bid_close_at > NOW()) > 0'));*/
            })
            ->when((!empty(array_filter($search))), function ($q) use ($search) {
                return $q->whereHas('tradeAgainst', function ($tradeAgainst) use ($search) {
                    return $tradeAgainst
                        ->where('kilometer', 'like', '%' . $search['keyword'] . '%')
                        ->orWhere('year', 'like', '%' . $search['keyword'] . '%')
                        ->orWhere('chassis', 'like', '%' . $search['keyword'] . '%')
                        ->orWhereHas('carModel', function ($carModel) use ($search) {
                            return $carModel->whereHas('translations', function ($tr) use ($search) {
                                return $tr->where('name', 'like', '%' . $search['keyword'] . '%')
                                    ->where('locale', App::getLocale('en'));
                            })
                                ->orWhereHas('brand', function ($brand) use ($search) {
                                    return $brand->whereHas('translations', function ($tr) use ($search) {
                                        return $tr->where('name', 'like', '%' . $search['keyword'] . '%')
                                            ->where('locale', App::getLocale('en'));
                                    });
                                });
                        });

                });
            })
            ->when(($status > 0), function ($q) use ($status) {
                return $q->where('status', $status);
            })
            /*->when((!empty(Auth::user()->cars()->pluck('id')->toArray())), function ($q) use ($status) {
                return $q->whereRaw(DB::raw('(`owner_car_id` IN (' . implode(",", Auth::user()->cars()->pluck('id')->toArray()) . ') OR owner_car_id IS NULL)'));
            })
            ->when((empty(Auth::user()->cars()->pluck('id')->toArray())), function ($q) use ($status) {
                return $q->whereRaw(DB::raw('(`owner_car_id` IN (0) OR owner_car_id IS NULL)'));
            })
            ->whereRaw(DB::raw('(`owner_car_id` IN (-1) OR owner_car_id IS NULL)'))
            ->whereIn('owner_car_id', array_merge(Auth::user()->cars()->pluck('id')->toArray(), [null]))
            ->orWhere(DB::raw('owner_car_id IS NULL'))*/
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();

        $input['user_id'] = Auth::id();

        $input['amount'] = null;

        // current date + 1
        $date = Carbon::now()->addDay();

        // day name in string
        $day = $date->format('l');

        //matches is this day is weekend
        if (in_array($day, TradeInCar::WEEK_END)) {

            // add 1 more day
            $expire_at = $date->addDay();

            // day name in string
            $expire_at_day = $expire_at->format('l');

            //matches is this day is weekend
            if (in_array($expire_at_day, TradeInCar::WEEK_END)) {

                // add 1 more day
                $expire_at = $date->addDay();
            }
        } else {
            $expire_at = $date;
        }
        $input['bid_close_at'] = $expire_at;

        $tradeInCar = $this->create($input);

        return $tradeInCar;
    }

    /**
     * @param $request
     * @param $tradeInCar
     * @return mixed
     */
    public function updateRecord($request, $tradeInCar)
    {
        $input = $request->only('amount');
        $tradeInCar = $this->update($input, $tradeInCar->id);

        /*if ($tradeInCar) {
            $this->notificationRepository = App::make(NotificationRepository::class);

            $notification = [
                'sender_id'   => $tradeInCar->user_id,
                'action_type' => Notification::NOTIFICATION_TYPE_NEW_BID,
                'url'         => null,
                'ref_id'      => $input['car_id'],
                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_NEW_BID]
            ];
            dd($notification);
            $this->notificationRepository->notification($notification, $bid->cars->owner_id);
        }*/

        return $tradeInCar;
    }
}
