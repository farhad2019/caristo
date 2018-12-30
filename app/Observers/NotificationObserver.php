<?php

namespace App\Observers;

use App\Jobs\SendPushNotification;
use App\Models\NotificationUser;
use App\Repositories\Admin\MyCarRepository;
use App\Repositories\Admin\TradeInCarRepository;

/**
 * @property mixed tradeInRequest
 */
class NotificationObserver
{
    protected $carRepository;

    /**
     * @param NotificationUser $notificationUser
     */
    public function created(NotificationUser $notificationUser)
    {
        $this->tradeInRequest = App()->make(TradeInCarRepository::class);
        $clientCar = $this->tradeInRequest->findWhere(['id' => $notificationUser->notification->ref_id]);
        $message = $notificationUser->notification->message;
        $deviceData = $notificationUser->user->devices->toArray();
        $extraPayload = [
            'ref_id' => $clientCar->my_car->id
        ];
        /*$carData = $this->carRepository->findWithoutFail($notificationUser->notification->ref_id);
        $extraData = [
            'image_url'  => $carData->media[0] ? $carData->media[0]->file_url : null,
            'car_name'   => $carData->name,
            'model_year' => $carData->year,
            'chassis'    => $carData->chassis
        ];*/

        $job = new SendPushNotification($message, $deviceData, $extraPayload);
        dispatch($job);
    }
}
