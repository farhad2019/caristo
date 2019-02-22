<?php

namespace App\Repositories\Admin;

use App\Models\CarsEvaluation;
use App\Models\CarEvaluationBid;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CarsEvaluationRepository
 * @package App\Repositories\Admin
 * @version January 15, 2019, 7:41 am UTC
 *
 * @method CarsEvaluation findWithoutFail($id, $columns = ['*'])
 * @method CarsEvaluation find($id, $columns = ['*'])
 * @method CarsEvaluation first($columns = ['*'])
 */
class CarEvaluationBidRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id',
        'car_id',
        'user_id',
        'amount'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return CarEvaluationBid::class;
    }

    /**
     * @param $request
     * @param $tradeInCar
     * @return mixed
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function saveRecord($request, $tradeInCar)
    {
        $input = $request->only('amount');
        $input['currency'] = Auth::user()->details->regionDetail->currency;
        $input['evaluation_id'] = $tradeInCar->id;
        $input['user_id'] = Auth::id();
        $input['status'] = 10;
        $carsEvaluation = $this->create($input);

        return $carsEvaluation;
    }

    /**
     * @param $request
     * @param $tradeInCar
     * @return mixed
     */
    public function updateRecord($request, $tradeInCar)
    {
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
}
