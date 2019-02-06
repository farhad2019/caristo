<?php

namespace App\Events;

use App\Models\RequestForQuotation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewJobEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userID;
    public $job;
    public $notification;

    /**
     * Create a new event instance.
     *
     * @param $userId
     */
    public function __construct($userId)
    {
        $this->userID = $userId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('job-' . $this->userID);
    }

    /**
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'data' => [
                'job' => 'Hello jani',
//                'job'          => $this->job,
//                'notification' => $this->notification,
//                'url'  => Url::route('view-job'),
//                'text' => __('new_job')
            ]
        ];
    }
}
