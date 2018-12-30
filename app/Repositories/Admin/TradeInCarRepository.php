<?php

namespace App\Repositories\Admin;

use App\Models\TradeInCar;
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
     * @param $id
     * @return mixed
     */
    public function getTradeInCarsWithoutBid($id = 0)
    {
        return $this->model->when(($id > 0), function ($q) use ($id) {
            return $q->where('owner_car_id', $id);
        })
            ->whereRaw(DB::raw('amount IS NULL'))
            ->get();
    }

    /**
     * @param int $id
     * @param bool $hasBid
     * @return mixed
     */
    public function getTradeInCars($id = 0, $hasBid = false)
    {
        return $this->model
            ->when(($id > 0), function ($q) use ($id) {
                return $q->where('owner_car_id', $id);
            })
            ->when(($hasBid), function ($q) use ($id) {
                return $q->whereRaw(DB::raw('amount IS NOT NULL'));
            })
            ->when((!$hasBid), function ($q) use ($id) {
                return $q->whereRaw(DB::raw('amount IS NULL'));
            })
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

//        if ($bid) {
//            $this->notificationRepository = App::make(NotificationRepository::class);
//
//            $notification = [
//                'sender_id'   => $bid->user_id,
//                'action_type' => Notification::NOTIFICATION_TYPE_NEW_BID,
//                'url'         => null,
//                'ref_id'      => $input['car_id'],
//                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_NEW_BID]
//            ];
//
//            $this->notificationRepository->notification($notification, $bid->cars->owner_id);
//        }

        return $tradeInCar;
    }
}
