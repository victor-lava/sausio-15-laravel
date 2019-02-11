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

        dd($checkers);

        $checker = Checker::where('game_id', $request->game_id)
                        ->where('x', $request->x)
                        ->where('y', $request->y)
                        ->first();
        $moves = [];

        if($checker->color == 0) { // white

            $xtl = $request->x - 1;
            $ytl = $request->y - 1;

            $xtr = $request->x + 1;
            $ytr = $request->y - 1;

            $checkers = Checker::where('game_id', $request->game_id)
                                ->where('x', $xtl)
                                ->where('y', $ytl)
                                ->orWhere(function($query) use ($xtr, $ytr)
                                {
                                    $query->where('x', $xtr)
                                          ->where('y', $ytr);
                                })
                                ->get();


            if(count($checkers) >= 1) {
                // dd($checkers);
                if($checkers[0]->x !== $xtl && $checkers[0]->y !== $ytl) {
                    $moves[] = [$xtr, $ytr];
                } else {
                    $moves[] = [$xtl, $ytl];
                }
            } else {
                $moves[] = [$xtl, $ytl];
                $moves[] = [$xtr, $ytr];
            }
            // if($checkers[$i]->x !== $checker->x + 1 &&
            //    $checkers[$i]->y !== $checker->y + 1) {
            //        $moves[] = [$checker->x + 1, $checker->y + 1];
            //    }
            // elseif ($checkers[$i]->x !== $checker->x - 1 &&
            //         $checkers[$i]->y !== $checker->y + 1) {
            //       $moves[] = [$checker->x - 1, $checker->y + 1];
            // }
        }


        dd($moves);

        // if($checker) {
        //     $this->response->status(200);
        //  }
        //
        // return $this->response->json();
    }
}
