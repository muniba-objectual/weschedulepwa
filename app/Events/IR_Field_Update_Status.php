<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class IR_Field_Update_Status extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

 protected $user;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PresenceChannel('IR');
    }

    public function broadcastAs()
    {
        return 'newMessage';
    }

    public function broadcastWith()
    {
        // This must always be an array. Since it will be parsed with json_encode()
        return [
            'user' => $this->user->name

        ];
    }

}
