<?php

namespace App\Http\Controllers\API;

use App\Checker;
use App\Game;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CheckerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    //tikrins ar saske ten yra pagal x ir y ir grazins square id ar x y kur gali ji nueiti
    public function find(Request $request) {

    }

    public function moves(Request $request) {

      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)->first();

      if($game) {
        $checker = Checker::where('x', $request->x)
                          ->where('y', $request->y)
                          ->first();
        if($checker) {

          // possible moves
          $possible = $game->findCheckerByCoordinates(2,1);

          // $possible1 = $game->findCheckerByCoordinates($request->x - 1, $request->y + 1);
          dd($possible);

          $data['status'] = 200;

        }
      }

      return response()->json($data);
    }

    public function move(Request $request) {

      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)->first();

      if($game) { // create issue in laravel
        $checker = Checker::where('x', $request->x1)
                          ->where('y', $request->y1)
                          ->update([  'x' => $request->x2,
                                      'y' => $request->y2]);
        // dd($checker);
        // dd(Checker::update());
        if($checker > 0) {

          $data['status'] = 200;
          $data['message'] = 'Checker succesfully moved';

        }
      }

      return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Checker  $checker
     * @return \Illuminate\Http\Response
     */
    public function show(Checker $checker)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Checker  $checker
     * @return \Illuminate\Http\Response
     */
    public function edit(Checker $checker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Checker  $checker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checker $checker)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Checker  $checker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checker $checker)
    {
        //
    }
}
