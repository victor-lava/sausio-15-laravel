<?php

use Illuminate\Http\Request;
use App\Checker;

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

Route::get('checker/moves', 'CheckerController@moves');

Route::get('checker/move', 'CheckerController@move');

Route::get('checker/find', 'CheckerController@find');
