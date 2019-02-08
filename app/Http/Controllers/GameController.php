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
        dd($this->findChecker($checkers, 0, 1));
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

        $game->start();

        return redirect()->route('game.index', $game->id);
    }

    private function createCheckers(int $gameID, array $table) {
        for ($y = 0; $y < count($table); $y++) { // y
            for ($x = 0; $x < count($table); $x++) {
                $checker = false;
                if(($y <= 2 || $y >= 5) && $table[$x][$y]['color'] === 1) {
                    $checker = new Checker();
                    $checker->game_id = $gameID;
                    $checker->user_id = null;
                    $checker->position_name = $table[$x][$y]['position'];
                    $checker->x = $x;
                    $checker->y = $y;
                    if($y <= 2) { $checker->color = 1; } // Black checker
                    elseif($y >= 5) { $checker->color = 0; } // White checker
                    $checker->save();
                }
                $table[$y][$x]['checker'] = $checker;
            }
        }
        return $table;
    }

    // private function createCheckers(int $gameID,
    //                                 int $userID) {
    //     $blacks = [];
    //     $tableSize = 8;
    //     $checkerAmount = 12;
    //
    //     for ($y = 0; $y < $tableSize; $y++) { // y
    //         for ($x = 0; $x < $tableSize; $x++) {
    //             if(count($blacks) >= $checkerAmount) { break; }
    //             if($table[$x][$y]['color'] === 1) { // black
    //                 $table[$x][$y]['checker'] = TRUE;
    //                 $checker = new Checker();
    //                 $checker->game_id = $gameID;
    //                 $checker->user_id = $userID;
    //                 $checker->position_name = $table[$x][$y]['position'];
    //                 $checker->x = $x;
    //                 $checker->y = $y;
    //                 $checker->color = 1; // black checker
    //                 $checker->save();
    //                 $blacks[] = $checker;
    //             }
    //         }
    //     }
    //
    //     $whites = [];
    //     for ($y = $tableSize - 1; $y >= 0; $y--) { // y
    //         for ($x = $tableSize - 1; $x >= 0; $x--) {
    //             if(count($whites) >= $checkerAmount) { break; }
    //             if($table[$x][$y]['color'] === 1) { // black
    //                 $table[$x][$y]['checker'] = TRUE;
    //                 $checker = new Checker();
    //                 $checker->game_id = $gameID;
    //                 $checker->user_id = $userID;
    //                 $checker->position_name = $table[$x][$y]['position'];
    //                 $checker->x = $x;
    //                 $checker->y = $y;
    //                 $checker->color = 0; // white checker
    //                 $checker->save();
    //                 $whites[] = $checker;
    //             }
    //         }
    //     }
    //
    //     return $table;
    // }

    private function createTable() {

        $squares = [];
        $alphabet = 'abcdefghijklmnopqrstuvwxyz';
        $alphabet = str_split($alphabet);
        $size = 8;

        for ($y = 0; $y < $size; $y++) { // y
            $rowNumber = $size - $y;
            $isYEven = $y % 2 ? true : false;
            $squares[$y] = [];

            for ($x = 0; $x < $size ; $x++) {
                $isXEven = $x % 2 ? true : false;
                $positionName = $alphabet[$x] . $rowNumber;
                $checker = false;

                if( ($isYEven == true && $isXEven == true) ||
                    ($isYEven == false && $isXEven == false)) { // White Squares
                        $color = 0;
                }
                elseif( ($isYEven == true && $isXEven == false) ||
                        ($isYEven == false && $isXEven == true)) { // Black Squares
                        $color = 1;



                        // 1. case kai kuriame lentelę naujai, tai kuriame pagal $y <= 2 || $y >= 5 taisykles
                        // if($y <= 2 || $y >= 5) {
                        //     $checker = new Checker();
                        //     $checker->game_id = $gameID;
                        //     $checker->user_id = null;
                        //     $checker->position_name = $positionName;
                        //     $checker->x = $x;
                        //     $checker->y = $y;
                        //     if($y <= 2) { $checker->color = 1; } // Black checker
                        //     elseif($y >= 5) { $checker->color = 0; } // White checker
                        //     $checker->save();
                        // }

                        // 2. case kai gauname lentelę iš duomenų bazės ir koordinatės yra sumaisytos, tada nekuriame checkeriu, bet juos uzfiliname i masyva
                        // $checker = $this->findChecker($checkers, $x, $y);
                }

                $squares[$y][$x]['color'] = $color;
                $squares[$y][$x]['position'] = $positionName;
                $squares[$y][$x]['checker'] = $checker;
            }

        }

        return $squares;

    }

    private function findChecker(object $checkers, int $x, int $y) {
        $result = false;

        foreach ($checkers as $checker) {
            if($checker->x === $x && $checker->y === $y) { $result = $checker; break; }
        }

        return $result;
    }
}
