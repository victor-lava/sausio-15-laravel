<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;

class GameController extends Controller
{
  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Game  $checker
   * @return \Illuminate\Http\Response
   */
  public function join(Request $request)
  {
    $data = [ 'status' => 404,
              'message' => 'Not found',
              'data' => null ];

    $game = Game::where('hash', $request->game_hash)
                  ->where('status', 0)
                  ->first();

    if($game) {
      // dd($request->color);
      /* Need to check a few things
        1. If user is not playing any games right now, if he's playing then joining the table isn't allowed
        2. If user is joing to another table and that table has a status of ongoing then
        we let him to join the new table. However we need to remove him from the old one
        and assign him to this one.
      */
      if($game->firstPlayer === null && $request->color == 0) { // whte
        $game->first_user_id = $request->user_id;
      } elseif ($game->secondPlayer === null && $request->color == 1) { // black
        $game->second_user_id = $request->user_id;
      }
      $game->save();
    }

    return $data;
  }
}
