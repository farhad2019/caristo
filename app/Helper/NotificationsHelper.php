<?php

namespace App\Helper;

use App\Models\NotificationUser;
use Edujugon\PushNotification\PushNotification;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

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
            ]));
            $push->setMessage([
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
            $push = new PushNotification('fcm');
            $push->setMessage([
                'data' => [
                    'title' => config('app.name'),
                    'body'  => $msg,
                    'badge' => Auth::user()->notifications()->where('status', NotificationUser::STATUS_DELIVERED)->count(),
                    'sound' => 'default',
                    'extra_payload'  => [
                        //'extra_payload' => $extraPayLoadData,
                        $extraPayLoadData,
                    ]
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


