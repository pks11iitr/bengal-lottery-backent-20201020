<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Game;
use App\Models\GameBook;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public function index(Request $request){
        $games=Game::where('isactive',1)->get();
        if($games->count()>0){
         return [
             'status'=>'success',
             'data'=>$games
             ];
           }else{
             return [
                  'status'=>'No Record Found',
                   'code'=>'402'
             ];
           }
    }

    public function gamedetails(Request $request){

     $user=auth()->guard('api')->user();
            if(!$user)
                return [
                    'status'=>'failed',
                    'message'=>'Please login to continue'
                ];

            $game=Game::find($request->game_id);
            $balance=Transaction::balance($user->id);
            $totaldeposit=Transaction::totaldeposit($user->id);
            $total=$totaldeposit;
            $date=date('Y-m-d H:i:s');
            $cdate=date('d M Y', strtotime($date));
            if($game){
             return [
                 'status'=>'success',
                 'data'=>compact('game','balance','total','cdate')
                 ];
               }else{
                 return [
                      'status'=>'No Record Found',
                       'code'=>'402'
                 ];
               }
        }

         public function gamebooking(Request $request){

             $user=auth()->guard('api')->user();
                        if(!$user)
                            return [
                                'status'=>'failed',
                                'message'=>'Please login to continue'
                            ];

                    $game=Game::find($request->game_id);
                 $digit=  $request->bid_digit??0;
                 $qty=  $request->bid_qty;
                 foreach($qty as $key=>$qt){
                $book=  GameBook::create([
                                     'user_id' => $user->id,
                                     'game_id' => $request->game_id,
                                     'game_timing' =>$game->game_time,
                                     'close_date' =>$game->close_date,
                                     'game_price' =>$game->price,
                                     'name' => $game->name,
                                     'bid_digit' => $qt,
                                     'bid_qty' => $qt,

                                 ]);
                 }
                    if($book){
                     return [
                         'status'=>'success',
                         'msg'=>'success',
                         ];
                       }else{
                         return [
                              'status'=>'failed',
                               'msg'=>'some error occoured'
                         ];
                       }
                }


}
