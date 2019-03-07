<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;
use App\Checker;
use Auth;

class GameController extends Controller
{
    // sending:
    // $user_id
    // $color
    // $game_hash

    public function leave(Request $request) {

    }

    public function join(Request $request) {
      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)
                    ->where('status', 0)
                    ->first();
      //
      if( $game && $game->validateRequest($request->auth_hash)) {

          if($game->seat->to(Auth::user()->id, $request->color)) {
            $data['message'] = 'Succesfully joined the game.';
            // event player joined the game
          }
          else {
            $data['message'] = "Can't join the game.";
          }

          if($game->seat->isBothSeated()) {
            $data['message'] .= ' Starting the game.';
            // event starting the game
            $game->start();
          } else {
            $data['message'] .= ' Waiting for other player.';
          }

          $data['status'] = 200;
          $data['data'] = $game;
      }

      return response()->json($data);
    }
}
