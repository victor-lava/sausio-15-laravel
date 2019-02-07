<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;

class GameController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $game = Game::find($id);

        return view('pages/game', compact('game'));
    }   

    public function create() {
        $game = new Game();
        $game->first_user_id = Auth::user()->id;
        $game->save();

        return redirect()->route('game.index', $game->id);
    }
}
