<?php

namespace App\Helper;

use App\Models\NotificationUser;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Config;

class NotificationsHelper
{
    function sendPushNotifications($msg = '', $deviceObject = [], $extraPayLoadData = [])
    {
        $androidDeviceToken = [];
        $iosDeviceToken = [];
        $deviceObject = isset($deviceObject[0]) ? $deviceObject : [$deviceObject];

        foreach ($deviceObject as $device):
            if (strtolower($device['device_type']) == 'android') {
                $androidDeviceToken[] = $device['device_token'];
            } elseif (strtolower($device['device_type']) == 'ios') {
                $iosDeviceToken[] = $device['device_token'];
            }
        endforeach;

        if (!empty($androidDeviceToken)) {
            /*exit(json_encode([
                'notification' => [
                    'title' => config('app.name'),
                    'body'  => $msg,
                    'sound' => 'default',
                    'data'  => [
                        'extra_payload' => $extraPayLoadData,
                    ],
                ]
            ]));*/
            $push = new PushNotification('fcm');
            /*$push->setMessage([
                'notification' => [
                    'title' => config('app.name'),
                    'body'  => $msg,
                    'sound' => 'default'
                ],
                'data'         => [
                    'extra_payload' => $extraPayLoadData
                ],
                'android'      => [
                    'ttl'          => '86400',
                    'notification' => [
                        'click_action' => 'MainActivity'
                    ]
                ]
            ])*/
            $push->setMessage([
                'notification' => [
                    'title' => config('app.name'),
                    'body'  => $msg,
                    'badge' => 0,//count(NotificationUser::findAll(['user_id' => $this->receiver->id, 'is_read' => 0, 'deleted_at' => null])),
                    'sound' => 'default',
                    'data'  => [
                        'extra_payload' => $extraPayLoadData,
                    ],
                ]
            ])
                ->setApiKey(Config::get('pushNotification.fcm.apiKey'))
                ->setConfig(['dry_run' => false])
                ->setDevicesToken($androidDeviceToken)
                ->send();
        }

        /*if ($androidDeviceToken) {
            $push = new PushNotification('fcm');
            $push->setMessage([
                'notification' => [
                    'title' => config('app.name'),
                    'body'  => $msg,
                    'sound' => 'default'
                ],
                'data'         => [
                    'action_type' => $extraPayLoadData['action_type'],
                    'ref_id'      => $extraPayLoadData['ref_id'],
                    'sender_id'   => $extraPayLoadData['sender_id']
                ],
                'android'      => [
                    'ttl'          => '86400',
                    'notification' => [
                        'click_action' => 'MainActivity'
                    ]
                ]
            ])
                ->setApiKey(Config::get('constants.pushNotification.fcm'))
                ->setConfig(['dry_run' => false])
                ->setDevicesToken($androidDeviceToken)
                ->send();
        }*/

        /*Apn*/
        if ($iosDeviceToken) {
            $push = new PushNotification('apn');

            $push->setMessage([
                'aps' => [
                    'alert'        => [
                        'title' => config('app.name'),
                        'body'  => $msg
                    ],
                    'sound'        => 'default',
                    'extraPayLoad' => [
                        'action_type' => $extraPayLoadData['action_type'],
                        'ref_id'      => $extraPayLoadData['ref_id'],
                    ]
                ]
            ])->setDevicesToken($iosDeviceToken)->send();
        }
        return true;
    }
}


