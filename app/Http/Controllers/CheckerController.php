<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Checker;
use App\Response;

class CheckerController extends Controller
{

    public $response;

    public function __construct() {
        $this->response = new Response();
    }

    public function find(Request $request) {

        $checker = Checker::where('game_id', $request->game_id)
                        ->where('x', $request->x)
                        ->where('y', $request->y)
                        ->first();

        if($checker) {
            $this->response->status(200);
            $this->response->data($checker);
         }

        return $this->response->json();
    }

    public function move(Request $request) {

        $checker = Checker::where('game_id', $request->game_id)
                        ->where('x', $request->x1)
                        ->where('y', $request->y1)
                        ->update([  'x' => $request->x2,
                                    'y' => $request->y2]);

        if($checker) {
            $this->response->status(200);
         }

        return $this->response->json();
    }

    public function moves(Request $request) {

        $checkers = Checker::where('game_id', $request->game_id)
                            ->get();

        $checker = Checker::where('game_id', $request->game_id)
                        ->where('x', $request->x)
                        ->where('y', $request->y)
                        ->first();
        $moves = [];

        for ($i = 0; $i < count($checkers); $i++) {
            if($checkers[$i]->color == 0) { // white
                if($checkers[$i]->x !== $checker->x + 1 &&
                   $checkers[$i]->y !== $checker->y + 1) {
                       $moves[] = [$checker->x + 1, $checker->y + 1];
                   }
                elseif ($checkers[$i]->x !== $checker->x - 1 &&
                        $checkers[$i]->y !== $checker->y + 1) {
                      $moves[] = [$checker->x - 1, $checker->y + 1];
                }
            }
        }

        dd($moves);

        // if($checker) {
        //     $this->response->status(200);
        //  }
        //
        // return $this->response->json();
    }
}
