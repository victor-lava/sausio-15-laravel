<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;

class GameController extends Controller
{
    // sending:
    // $user_id
    // $color
    // $game_hash

    public function join(Request $request) {
      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)
                    ->where('status', 0)
                    ->first();

      if($game) {
        // dd($game);
         $joined = false;
          if( $request->color === 'white' &&
              $game->first_user_id === null) { // empty seat

              $joined = true;

              $game->update(['first_user_id' => $request->user_id]);

              // dd($request->user_id);
              if($game->second_user_id === (int) $request->user_id) {
                $game->update(['second_user_id' => null]);
              }

          } elseif ($request->color === 'black' &&
                    $game->second_user_id === null) {

             $joined = true;

             $game->update(['second_user_id' => $request->user_id]);

             if($game->first_user_id === (int) $request->user_id) {
               $game->update(['first_user_id' => null]);
             }
          }

          $data['status'] = ($joined) ? 200 : 400;
          $data['data'] = $game;
          $data['message'] = ($joined) ? 'Succesfully joined the game.' : "Can't join the game";

      }

      return response()->json($data);
    }
}
