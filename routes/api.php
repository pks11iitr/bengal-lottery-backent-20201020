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
 $api = app('Dingo\Api\Routing\Router');
 $api->post('login', ['as'=>'api.login', 'uses'=>'Auth\Api\LoginController@login']);

 $api->get('game-list', ['as'=>'api.login', 'uses'=>'Portal\Api\GameController@index']);
$api->get('game-details', ['as'=>'api.details', 'uses'=>'Portal\Api\GameController@gamedetails']);

 $api->get('game-list', ['as'=>'api.game', 'uses'=>'Portal\Api\GameController@index']);
 $api->post('game-book', ['as'=>'api.gamebooking', 'uses'=>'Portal\Api\GameController@gamebooking']);
$api->get('game-history', ['as'=>'api.gamehistory', 'uses'=>'Portal\Api\BookingHistoryController@index']);


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();





});
