<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Game;
use App\Models\GameBook;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public function index(Request $request){
        $user=auth()->guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];
        $games=Game::where('isactive',1)->get();
        $balance=Transaction::balance($user->id);
        $totaldeposit=Transaction::totaldeposit($user->id);
        $total=$totaldeposit;
        if($games->count()>0){
         return [
             'status'=>'success',
             'data'=>$games,
             'balance'=>$balance,
             'total'=>$total,
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
               //  $digit=  $request->bid_digit??0;


//             $bookorder=  Order::create([
//                 'user_id' => $user->id,
//                 'game_id' => $request->game_id,
//                 'status' =>'pending',
//                 'winning_amount' =>$request->winning_amount,
//                 'winning_digit' =>$game->degit,
//                 'game_timing' =>$game->game_time,
//                 'close_date' =>$game->close_date,
//                 'game_price' =>$game->price,
//                 'name' => $game->name,
//
//             ]);
             $qty=  $request->bid_qty;
                 foreach($qty as $key=>$qt){
                     if($qt>0){
                         $book=  GameBook::create([
                             'user_id' => $user->id,
                            // 'order_id' => $bookorder->id,
                             'game_id' => $request->game_id,
                             'game_timing' =>$game->game_time,
                             'close_date' =>$game->close_date,
                             'game_price' =>$game->price,
                             'name' => $game->name,
                             'bid_number' => $game->degit,
                             'bid_digit' => $key,
                             'bid_qty' => $qt,

                         ]);
                     }

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
