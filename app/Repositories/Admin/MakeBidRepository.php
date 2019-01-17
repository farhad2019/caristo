<?php

namespace App\Repositories\Admin;

use App\Models\MakeBid;
use App\Models\MyCar;
use App\Models\Notification;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class MakeBidRepository
 * @package App\Repositories\Admin
 * @version October 12, 2018, 1:16 pm UTC
 *
 * @method MakeBid findWithoutFail($id, $columns = ['*'])
 * @method MakeBid find($id, $columns = ['*'])
 * @method MakeBid first($columns = ['*'])
 */
class MakeBidRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'car_id',
        'user_id',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MakeBid::class;
    }

    protected $notificationRepository;

    /**
     * @param $request
     * @return mixed
     */
    public function saveRecord($request)
    {
        $input = $request->only('amount', 'car_id');
        $input['user_id'] = Auth::id();
        $bid = $this->create($input);

//        if ($bid) {
//            $this->notificationRepository = App::make(NotificationRepository::class);
//
//            $notification = [
//                'sender_id'   => $bid->user_id,
//                'action_type' => Notification::NOTIFICATION_TYPE_TRADE_IN_NEW_BID,
//                'url'         => null,
//                'ref_id'      => $input['car_id'],
//                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_TRADE_IN_NEW_BID]
//            ];
//
//            $this->notificationRepository->notification($notification, $bid->cars->owner_id);
//        }

        return $bid;
    }
}
