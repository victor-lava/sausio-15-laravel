<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\GameLeave;
use App\Events\GameJoin;
use App\Game;
use App\Checker;
use Auth;

class GameController extends Controller
{

    public function leave(Request $request) {
      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)
                    ->where('status', 0)
                    ->first();

      if( $game && $game->validateRequest($request->auth_hash)) {
          $userID = Auth::user()->id;
          $status = false;

          if($game->seat->out($userID, $request->color)) {
            $data['message'] = 'Succesfully left the game.';
          }

          $data['status'] = 200;
          $data['data'] = ['action' => 'game-leave',
                           'game_hash' => $request->game_hash,
                           'color' => $request->color,
                           'user_id' => $userID,
                           'seat' => $request->color];

          event(new GameLeave($data));
      }

      return response()->json($data);
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
          $userID = Auth::user()->id;
          $status = false;



          if($game->seat->to($userID, $request->color)) {
            $data['message'] = 'Succesfully joined the game.';
            // $status = 'joined';
            // event player joined the game
          }
          else {
            $data['message'] = "Can't join the game.";
            // $status = 'cannot';
          }

          if($game->seat->isBothSeated()) {
            $data['message'] .= ' Starting the game.';
            // $status = 'starting';
            // event starting the game
            $game->start();
          } else {
            $data['message'] .= ' Waiting for other player.';
            // $status = 'waiting';
          }

          $data['status'] = 200;
          $data['data'] = [ 'action' => $game->seat->switched ? 'game-switch' : 'game-join',
                            'game_hash' => $request->game_hash,
                            'color' => $request->color,
                            'user_id' => $userID,
                            'user_name' => Auth::user()->name,
                            'seat' => $request->color];

          event(new GameJoin($data));
      }

      return response()->json($data);
    }
}
