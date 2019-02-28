<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use App\User;

class GameController extends Controller
{


    public function show(string $hash) {

        $game = Game::where('hash', $hash)->first();
        $isLogged = false;
        $isPlaying = false;
        $oponnentID = false;

        if(Auth::user()) {
          $isLogged = true;
          if($game->firstPlayer->token === Auth::user()->token) {
            $isPlaying = true;
            $oponnentID = $game->secondPlayer->id;
            $color = 0;
          } elseif ($game->secondPlayer->token === Auth::user()->token) {
            $isPlaying = true;
            $oponnentID = $game->firstPlayer->id;
            $color = 1;
          }
        }

        $squares = $game->createGameTable();


        return view('pages/game', compact('squares',
                                          'hash',
                                          'isLogged',
                                          'isPlaying',
                                          'color',
                                          'oponnentID'));

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
