<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PostPusherEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Only (!) Public members will be serialized to JSON and sent to Pusher
     **/
    public $message;
    public $postId;
    public $follower;

    /**
     * Create a new event instance.
     * @param string $message (notification description)
     * @param integer $id (notification id)
     * @param integer $for_user_id (receiver's id)
     * @return void
     */
    public function __construct($message,$postId, $follower)
    {
        $this->message = $message;
        $this->postId = $postId;
        $this->follower = $follower;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        //We have created names of channel on basis of user's id who
        //will receive data from this class.
        //See frontend pusher code to see how we have used this channel
        //for intended user.
        return ['post-notification-channel'];
    }
}
