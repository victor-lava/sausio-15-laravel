<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:api')->group(function () {
//   // Route::get('/checker/move', 'API\CheckerController@move')->name('api.checker.move');
//   //
//   // Route::get('/checker/moves', 'API\CheckerController@moves')->name('api.checker.moves');
//   //
//   // Route::get('/game/join', 'API\GameController@join')->name('api.game.join');
// });
