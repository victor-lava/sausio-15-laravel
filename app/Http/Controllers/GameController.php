<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use App\User;

class GameController extends Controller
{


    public function show(string $hash) {

      // dd(Auth::user());
        $authHash = false;
        $color = false;
        $game = Game::where('hash', $hash)->first();

        // dd($squares);
        // dd($game->firstPlayer->checker);

        if(Auth::user()) { // logged in
          $token = Auth::user()->token;

          if($token === $game->firstPlayer->token) {
            $authHash = $token;
            $color = 0; // white
          } elseif ($token === $game->secondPlayer->token) {
            $authHash = $token;
            $color = 1; // black
          }
        }

        // dd($color . ' ' . $authHash);
        $squares = $game->createGameTable($authHash, $color);
        return view('pages/game', compact('hash', 'squares', 'authHash'));

    }

    public function create() {

        $userID = Auth::user()->id;

        $gameFound = Game::where('first_user_id', $userID)
                         ->orWhere('second_user_id', $userID)
                         ->where(function($query) use ($userID) { // "use" paima iš parent scope kintamajį ir nusiunčią į bevardės funkcijos lokalų scope
                             // $userID galima paiimti tada
                             $query->where('status', 0)
                                    ->orWhere('status', 1);
                         })
                         ->first();


        if(!$gameFound) {
            $game = new Game();
            $game->first_user_id = Auth::user()->id;
            $game->hash = md5($game->first_user_id . time());
            $game->save();
            $gameHash = $game->hash;
        } else {
            $gameHash = $gameFound->hash;
        }

        return redirect()->route('game.show', $gameHash);
    }
}
