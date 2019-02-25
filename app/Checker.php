<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checker extends Model
{
    public $timestamps = false;

    public function colorName() {
      return $this->color === 1 ? 'black' : 'white';
    }

    public function user() {
      return $this->belongsTo('App\User');
    }

    // public function game() {
    //   $game = App\Game::where('id', $this->game_id)->first();
    //   if($game) {
    //     return $game;
    //   } else {
    //     return false;
    //   }
    // }
}
