<?php

namespace App\Repositories\Admin;

use App\Models\TradeInCar;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

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
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();
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
