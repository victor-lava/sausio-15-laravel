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
        $checkers = Checker::where('game_id', $id)->get();
        // dd($checkers);
        // dd($game->findChecker($checkers, 0, 1));
        // dd($game->getGameTable($checkers));
        $table = $game->getGameTable($checkers);

        // $this->moveChecker([1,0], [4,3]);

        // $tableArray = $this->generateTable(8);
        // $table = $this->createCheckers($tableArray, 12, $id, Auth::user()->id);
        // // $checkers = Checker::where('game_id', $id)->get();
        //
        // // dd($checkers);

        return view('pages/game', compact('game', 'table'));
    }


    public function create() {
        $game = new Game();
        $game->first_user_id = Auth::user()->id;
        $game->save();

        $game->create();

        return redirect()->route('game.index', $game->id);
    }


    public function moveChecker(array $from, array $to) {

        $checker = Checker::where('game_id', 12)
                    ->where('x', $from[0])
                    ->where('y', $from[1])
                    ->update([  'x' => $to[0],
                                'y' => $to[1]
                            ]);
    }

    private function findChecker(object $checkers, int $x, int $y) {
        $result = false;

        foreach ($checkers as $checker) {
            if($checker->x === $x && $checker->y === $y) { $result = $checker; break; }
        }

        return $result;
    }
}
