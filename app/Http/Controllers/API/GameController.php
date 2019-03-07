<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Game;
use App\Checker;

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
          $jsData = ['seated' => null, 'seated_user' => null];

          if( $request->color === 'white' &&
              $game->first_user_id === null) { // empty seat

              $joined = true;

              $game->update(['first_user_id' => $request->user_id]);

              // dd($request->user_id);
              if($game->second_user_id === (int) $request->user_id) {
                $game->update(['second_user_id' => null]);
              }

              $jsData['seated'] = 'white';
              $jsData['seated_user'] = $game->firstPlayer->name;

          } elseif ($request->color === 'black' &&
                    $game->second_user_id === null) {

             $joined = true;

             $game->update(['second_user_id' => $request->user_id]);

             if($game->first_user_id === (int) $request->user_id) {
               $game->update(['first_user_id' => null]);
             }

             $jsData['seated'] = 'black';
             $jsData['seated_user'] = $game->secondPlayer->name;
          }

          if($game->first_user_id !== null &&
             $game->second_user_id !== null) { // game is starting


               $game->update(['status' => 1,
                              'started_at' => date('Y-m-d H:i:s', time())]);

               Checker::where('game_id', $game->id)
                          ->where('color', 0)
                          ->update(['user_id' => $game->first_user_id]);

               Checker::where('game_id', $game->id)
                           ->where('color', 1)
                           ->update(['user_id' => $game->second_user_id]);

          }

          $game->js = $jsData;

          $data['status'] = ($joined) ? 200 : 400;
          $data['data'] = $game;
          $data['message'] = ($joined) ? 'Succesfully joined the game.' : "Can't join the game";

      }

      return response()->json($data);
    }
}
