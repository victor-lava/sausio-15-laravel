<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameLeave implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $action;
    public $game_hash;
    public $user_id;
    public $seat;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $response)
    {
        $response = $response['data'];
        $this->action = $response['action'];
        $this->game_hash = $response['game_hash'];
        $this->user_id = $response['user_id'];
        $this->seat = $response['seat'];
    }

    public function broadcastOn()
    {
        return new Channel($this->game_hash);
    }

    public function broadCastAs() {
      return 'game-leave';
    }
}
