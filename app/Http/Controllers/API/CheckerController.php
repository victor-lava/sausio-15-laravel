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
        $checker = Checker::where('game_id', $game->id)
                          ->where('x', $request->x)
                          ->where('y', $request->y)
                          ->where('dead', 0)
                          ->first();

        if($checker) {


          $squares = $game->getAround($checker);
          $moves = $game->filterMoves($checker, $squares);
          // dd($moves);

          $data['status'] = 200;
          $data['data'] = $moves;
          $data['message'] = count($moves) > 0 ? 'Found some possibilities' : 'No moves found';

        }
      }

      return response()->json($data);
    }

    public function calcVector(array $from, array $to) {

      $x = ($to['x'] - $from['x']) / 2;
      $y = ($to['y'] - $from['y']) / 2;

      return ['x' => $x, 'y' => $y];

    }

    public function calcEnemy($request) {
      $vector = $this->calcVector(['x' => $request->x1,
                                   'y' => $request->y1],
                                  ['x' => $request->x2,
                                  'y' => $request->y2]);

      $x = $request->x1 + $vector['x'];
      $y = $request->y1 + $vector['y'];

      return ['x' => $x, 'y' => $y];
    }

    public function move(Request $request) {

      $data = [ 'status' => 404,
                'message' => 'Not found',
                'data' => null ];

      $game = Game::where('hash', $request->game_hash)->first();

      if($game) { // create issue in laravel
        $checker = Checker::where('game_id', $game->id)
                          ->where('x', $request->x1)
                          ->where('y', $request->y1)
                          ->where('dead', 0)
                          ->update([  'x' => $request->x2,
                                      'y' => $request->y2]);




        if($checker > 0) {
          $data['status'] = 200;
          $data['message'] = 'Checker succesfully moved';

          $enemyLocation = $this->calcEnemy($request);
          $enemy = Checker::where('x', $enemyLocation['x'])
                            ->where('y', $enemyLocation['y'])
                            ->update(['dead' => 1]);
          if($enemy > 0) {
            $data['data'] = $enemyLocation;
          }

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
