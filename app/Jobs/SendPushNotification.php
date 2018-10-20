<?php

namespace App\Jobs;

use App\Models\NotificationUser;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Helper;
use Illuminate\Support\Facades\Auth;

class SendPushNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $deviceTokens = array(), $msg, $extraPayLoadData = array(), $badgeCount, $notificationHelper;

//    public $tries = 5;

    /**
     * SendPushNotification constructor.
     * @param $msg
     * @param $deviceToken
     * @param $extraData
     */
    public function __construct($msg, $deviceToken, $extraData)
    {
        $this->deviceTokens = $deviceToken;
        $this->msg = $msg;
//        $this->badgeCount = Auth::user()->notifications()->where('status', NotificationUser::STATUS_DELIVERED)->count();
//        dd($this->badgeCount);
        $this->extraPayLoadData = $extraData;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->notificationHelper = new Helper\NotificationsHelper();
        $this->notificationHelper->sendPushNotifications($this->msg, $this->deviceTokens, $this->extraPayLoadData);
    }
}
