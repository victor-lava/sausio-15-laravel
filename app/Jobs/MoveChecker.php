<?php

namespace App\Jobs;

use App\Events\CheckerMoved;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class MoveChecker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user_id;
    public $game_hash;
    public $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $game_hash, $data)
    {
        $this->user_id = $user_id;
        $this->game_hash = $game_hash;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      event(new CheckerMoved( $this->game_hash,
                              $this->user_id,
                              $this->data));
    }
}
