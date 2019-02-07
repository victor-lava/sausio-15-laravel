<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Game;
use App\Checker;

class GameController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    public function index($id) {
        $game = Game::find($id);
        $table = $this->generateTable(8);
        // $checkers = Checker::where('game_id', $id)->get();

        // dd($checkers);

        return view('pages/game', compact('game', 'table'));
    }

    public function create() {
        // $game = new Game();
        // $game->first_user_id = Auth::user()->id;
        // $game->save();

        // $table = $this->generateTable(8);
        // dd($table);

        // return redirect()->route('game.index', $game->id);
    }

    private function generateTable(int $size) {

        $table = [];
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet = str_split($alphabet);

        for ($y = 0; $y < $size; $y++) { // y
            $rowNumber = $size - $y;
            $isYEven = $y % 2 ? true : false;
            $table[$y] = [];

            for ($x = 0; $x < $size ; $x++) {
                $isXEven = $x % 2 ? true : false;

                if( ($isYEven == true && $isXEven == true) ||
                    ($isYEven == false && $isXEven == false)) {
                        $color = 'white';
                }
                elseif( ($isYEven == true && $isXEven == false) ||
                        ($isYEven == false && $isXEven == true)) {
                        $color = 'black';
                }

                $table[$y][$x]['color'] = $color;
                $table[$y][$x]['position'] = $alphabet[$x] . $rowNumber;
            }

        }

        return $table;

    }
}
