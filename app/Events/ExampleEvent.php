<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ExampleEvent implements ShouldBroadcast
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


    public function broadcastWith()
    {
        return [
            'data' => [
                'hello_note' => 'Hello Jani'
            ]
        ];
    }
}
