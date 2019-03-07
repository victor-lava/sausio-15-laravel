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
      if( $game &&
          $game->validateRequest($request->auth_hash)) {
            // dd('valid');
        // dd('valid');
      //   // dd($game);
      //     $joined = false;
      //     $jsData = ['seated' => null, 'seated_user' => null];

          // $game->seatTo($request->color, Auth::user()->id);

          $game->seat->to($request->color,
                          Auth::user()->id);

          // if($request->color === 'white' &&
          //    $game->isSeatWhiteEmpty()){
          //      $game->seatWhite(Auth::user()->id);
          //
          // }
          // elseif ($request->color === 'black' &&
          //         $game->isSeatBlackEmpty()){
          //
          //           $game->seatBlack(Auth::user()->id);
          //
          // }

      //

      //
      //     if($game->first_user_id !== null &&
      //        $game->second_user_id !== null) { // game is starting
      //
      //
      //          $game->update(['status' => 1,
      //                         'started_at' => date('Y-m-d H:i:s', time())]);
      //
      //          Checker::where('game_id', $game->id)
      //                     ->where('color', 0)
      //                     ->update(['user_id' => $game->first_user_id]);
      //
      //          Checker::where('game_id', $game->id)
      //                      ->where('color', 1)
      //                      ->update(['user_id' => $game->second_user_id]);
      //
      //     }
      //
      //     $game->js = $jsData;
      //
      //     $data['status'] = ($joined) ? 200 : 400;
      //     $data['data'] = $game;
      //     $data['message'] = ($joined) ? 'Succesfully joined the game.' : "Can't join the game";
      //
      }

      return response()->json($data);
    }
}
