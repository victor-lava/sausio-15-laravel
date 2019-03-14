<?php

namespace App\Events;

use App\Game;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class GameCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data;
    public $html;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($game)
    {
        $this->data = $game;
        $this->html = $this->createHTML($game);
    }
    // dd($this->data->firstPlayer);

    private function createHTML($game) {
      $game->broadcasted = true;
      return view('partials/games/row', compact('game'))->render();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
     public function broadcastOn()
     {
         return new Channel('GameList');
     }

     public function broadCastAs() {
       return 'created';
     }
}
