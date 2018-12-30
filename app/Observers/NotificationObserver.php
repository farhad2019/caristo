<?php

namespace App\Observers;

use App\Jobs\SendPushNotification;
use App\Models\NotificationUser;
use App\Repositories\Admin\MyCarRepository;

class NotificationObserver
{
    protected $carRepository;

    /**
     * @param NotificationUser $notificationUser
     */
    public function created(NotificationUser $notificationUser)
    {
        //$this->carRepository = App()->make(MyCarRepository::class);
        $message = $notificationUser->notification->message;
        $deviceData = $notificationUser->user->devices->toArray();
        $extraPayload = [
            'ref_id' => $notificationUser->notification->ref_id
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
