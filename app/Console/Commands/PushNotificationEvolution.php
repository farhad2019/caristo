<?php

namespace App\Console\Commands;

use App\Models\Notification;
use App\Repositories\Admin\NotificationRepository;
use App\Repositories\Admin\TradeInCarRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\App;

class PushNotificationEvolution extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'evolution:push';
    protected $tradeInRepository;
    protected $notificationRepository;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert user that evolution request is ready to view.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $this->tradeInRepository = App::make(TradeInCarRepository::class);
        $this->notificationRepository = App::make(NotificationRepository::class);
        $evolutions = $this->tradeInRepository->getClosedBids();
        foreach ($evolutions as $key => $evolution) {
            $notification = [
                'sender_id'   => 2,
                'action_type' => Notification::NOTIFICATION_TYPE_EVALUATION_NEW_BID,
                'url'         => null,
                'ref_id'      => $evolution->id,
                'message'     => Notification::$NOTIFICATION_MESSAGE[Notification::NOTIFICATION_TYPE_EVALUATION_NEW_BID]
            ];
            $this->notificationRepository->notification($notification, $evolution->tradeAgainst->owner_id);
        }
    }
}