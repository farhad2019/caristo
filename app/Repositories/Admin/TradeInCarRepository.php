<?php

namespace App\Repositories\Admin;

use App\Models\MyCar;
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

    protected $myCarRepo;

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
        $brand_cars = App::make(MyCarRepository::class)->whereHas('carModel', function ($carModel) {
            return $carModel->whereIn('brand_id', Auth::user()->brands()->pluck('id')->toArray());
        })->pluck('id');

        $user_brand_related_cars = ($brand_cars->count() > 0) ? implode(",", $brand_cars->toArray()) : 0;

        return $this->model
            ->when(($hasBid), function ($q) use ($cars) {
                return $q->whereRaw(DB::raw('CASE
                    WHEN trade_in_cars.type = ' . TradeInCar::TRADE_IN . '  
                    THEN amount IS NOT NULL AND (`owner_car_id` IN (' . $cars . ') OR user_id = ' . Auth::id() . ')
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
            ->when((!$hasBid), function ($q) use ($cars, $user_brand_related_cars) {
                return $q->whereRaw(DB::raw('CASE
                    WHEN trade_in_cars.type = ' . TradeInCar::TRADE_IN . '  
                    THEN amount IS NULL AND (`owner_car_id` IN (' . $cars . ') OR user_id = ' . Auth::id() . ')
                    WHEN trade_in_cars.type = ' . TradeInCar::EVALUATE_CAR . '  
                    THEN `owner_car_id` IS NULL  AND `customer_car_id` IN (' . $user_brand_related_cars . ') AND trade_in_cars.created_at > "' . Auth::user()->created_at . '" AND NOT EXISTS 
                    (SELECT * FROM `car_evaluation_bids` 
                    WHERE `trade_in_cars`.`id` = `car_evaluation_bids`.`evaluation_id` 
                      AND `user_id` = ' . Auth::id() . ' AND `car_evaluation_bids`.`deleted_at` IS NULL) 
                  END'));
                /*return $q->whereRaw(DB::raw('amount IS NULL'))
                    ->whereDoesntHave('evaluationDetails', function ($qq) {
                        return $qq->where('user_id', Auth::id());
                    });
                ->whereRaw(DB::raw('(bid_close_at > NOW()) > 0'));*/
            })
            ->when((!empty(array_filter($search))), function ($q) use ($search) {
                return $q
                    ->when(isset($search['filerBy']), function ($filerBy) use ($search) {
                        return $filerBy->where('type', (int)$search['filerBy']);
                    })
                    ->when(isset($search['keyword']), function ($keyword) use ($search) {
                        return $keyword->whereHas('tradeAgainst', function ($tradeAgainst) use ($search) {
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
                    });
            })
            ->when(($status > 0), function ($q) use ($status) {
                return $q->where('status', $status);
            })
//            ->whereHas('tradeAgainst', function ($tradeAgainst) {
//                return $tradeAgainst->whereHas('owner', function ($owner) {
//                    return $owner->whereHas('details', function ($details) {
//                        return $details->where('region_id', Auth::user()->details->region_id);
//                    });
//                });
//            })
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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        if ($input['type'] == TradeInCar::TRADE_IN) {
            $this->myCarRepo = App::make(MyCarRepository::class);
            $owner_car_id = $this->myCarRepo->find($input['owner_car_id']);
            if ($owner_car_id->category_id == MyCar::LIMITED_EDITION) {
                foreach ($owner_car_id->dealers as $dealer) {
                    $input['user_id'] = $dealer->id;
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
                }
                return $tradeInCar;
            }
        }

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
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function updateRecord($request, $tradeInCar)
    {
        $input = $request->only('amount');
        $input['currency'] = Auth::user()->details->regionDetail->currency;
        $tradeInCar = $this->update($input, $tradeInCar->id);

        /*if ($tradeInCar) {
            $this->notificationRepository = App::make(NotificationRepository::class);

            $notification = [
                'sender_id'   => $tradeInCar->user_id,
                'action_type' => Notification::NOTIFICATION_TYPE_TRADE_IN_NEW_BID,
                'url'         => null,
                'ref_id'      => $input['car_id'],
                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_TRADE_IN_NEW_BID]
            ];
            dd($notification);
            $this->notificationRepository->notification($notification, $bid->cars->owner_id);
        }*/

        return $tradeInCar;
    }

    /**
     * @return mixed
     */
    public function getClosedBids()
    {
        return $this->model
            ->where(['type' => TradeInCar::EVALUATE_CAR, 'status' => TradeInCar::UNREAD])
            ->whereRaw(DB::raw('(bid_close_at < NOW()) > 0'))
            ->get();
    }
}
