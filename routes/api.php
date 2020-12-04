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
 $api->post('change-password', ['as'=>'api.changelogin', 'uses'=>'Auth\Api\LoginController@updatePassword']);


$api->group(['middleware' => ['isactiveuser']], function ($api) {
    $api->get('game-list', ['as' => 'api.login', 'uses' => 'Portal\Api\GameController@index']);
    $api->get('game-details', ['as' => 'api.details', 'uses' => 'Portal\Api\GameController@gamedetails']);
    $api->get('game-list', ['as' => 'api.game', 'uses' => 'Portal\Api\GameController@index']);
    $api->post('game-book', ['as' => 'api.gamebooking', 'uses' => 'Portal\Api\GameController@gamebooking']);
    $api->get('game-history', ['as' => 'api.gamehistory', 'uses' => 'Portal\Api\BookingHistoryController@index']);
    $api->get('history-game', ['as' => 'api.history.game', 'uses' => 'Portal\Api\BookingHistoryController@historygame']);
    $api->get('downline-game', ['as' => 'api.history.game', 'uses' => 'Portal\Api\BookingHistoryController@downlinegame']);
    $api->get('game-result', ['as' => 'api.result.game', 'uses' => 'Portal\Api\BookingHistoryController@gameresult']);
    $api->get('downline-history', ['as' => 'api.downline', 'uses' => 'Portal\Api\DownlineController@index']);
    $api->get('notifications', ['as' => 'notifications.list', 'uses' => 'Portal\Api\NotificationController@index']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();





});

$api->get('privacy-policy', ['as'=>'api.policy', 'uses'=>'Portal\Api\AppUrlController@privacypolicy']);
$api->get('terms-condition', ['as'=>'api.policy', 'uses'=>'Portal\Api\AppUrlController@termscondition']);
$api->get('about-us', ['as'=>'api.policy', 'uses'=>'Portal\Api\AppUrlController@aboutus']);


