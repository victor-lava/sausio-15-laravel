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
}
