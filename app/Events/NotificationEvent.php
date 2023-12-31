<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotificationEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    // public $message;
    public $notification;

    public function __construct($notification)
    {
        //   $this->message = $message;
        $this->notification = $notification;
    }

    public function broadcastOn()
    {
        // channel
        return ['Notification-development'];
    }

    public function broadcastAs()
    {
        // event
        return 'NotificationEvent';
    }
}
