<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Game;
use App\Models\GameBook;
use App\Models\GamePrice;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
date_default_timezone_set('Asia/Kolkata');
class GameController extends Controller
{

    public function index(Request $request){
        $user=auth()->guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];
        $gamess=Game::where('isactive',1)->get();
        $games=array();
        foreach($gamess as $game){
            $date=$game->orginal;
            $time=$game->time;
            $datetime=$date." ".$time;
            // var_dump($datetime);die;
            $enddate=strtotime($datetime);
            $newdate=date('Y-m-d H:i');
            $current=strtotime($newdate);
            $remaining=($enddate-$current)*1000;
            $games[]=array(

                'id'=>$game->id,
                'name'=>$game->name,
                'close_date'=>$game->close_date,
                'game_time'=>$game->game_time,
                'price'=>$game->price,
                'degit'=>$game->degit,
                'bid_qty'=>$game->bid_qty,
                'orginal'=>$game->orginal,
                'time'=>$game->time,
                'remaining'=>$remaining,
            );

        }



        $balance=Transaction::balance($user->id);
        $totaldeposit=Transaction::totaldeposit($user->id);
        $total=$totaldeposit;
        if(count($games)>0){
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

        $games=Game::find($request->game_id);

        // $games=GamePrice::with('game')->where('agent_id',$user->parent_id)->where('game_id',$request->game_id)->first();
        // var_dump($game);die;
        if(!$games){
            return [
                'status'=>'failed',
                'message'=>'Please Contact to Agent'
            ];
        }
        $game=array(
            'id'=>$games->id,
            'name'=>$games->name,
            'close_date'=>$games->close_date,
            'game_time'=>$games->game_time,
            'isactive'=>$games->isactive,
            'degit'=>$games->degit,
            'bid_qty'=>$games->bid_qty,
            'orginal'=>$games->orginal,
            'time'=>$games->time,
            'price'=>$user->rate
        );
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

        $games=Game::find($request->game_id);
        // $games=GamePrice::with('game')->where('agent_id',$user->parent_id)->where('game_id',$request->game_id)->first();
        $game=array(
            'id'=>$games->id,
            'name'=>$games->name,
            'close_date'=>$games->close_date,
            'game_time'=>$games->game_time,
            'isactive'=>$games->isactive,
            'degit'=>$games->degit,
            'bid_qty'=>$games->bid_qty,
            'orginal'=>$games->orginal,
            'time'=>$games->time,
            'price'=>$user->rate
        );
        // var_dump($game['degit']);die();
        //  $digit=  $request->bid_digit??0;
        $total=0;
        $havingorder = Order::where('user_id',$user->id)->where('game_id',$request->game_id)->first();
        if(!$havingorder) {

            $bookorder = Order::create([
                'user_id' => $user->id,
                'game_id' => $request->game_id,
                'status' => 'pending',
                'winning_amount' => $request->winning_amount,
                'winning_digit' => $game['degit'],
                'game_timing' => $game['game_time'],
                'close_date' => $game['close_date'],
                'game_price' => $user->rate,
                'name' => $game['name'],

            ]);
            $bookorder=$bookorder->id;
        }else{
            $bookorder= $havingorder->id;
        }
        $qty=  $request->bid_qty;
        foreach($qty as $key=>$qt){
            if($qt>0){
                $book=  GameBook::create([
                    'user_id' => $user->id,
                    'order_id' => $bookorder,
                    'game_id' => $request->game_id,
                    'game_timing' =>$game['game_time'],
                    'close_date' =>$game['close_date'],
                    'game_price' =>$user->rate,
                    'name' => $game['name'],
                    'bid_number' => $game['degit'],
                    'bid_digit' => $key,
                    'bid_qty' => $qt,

                ]);
                $total=$total+($qt*$user->rate??'0');
            }

        }
        $withdraw=Transaction::create([
            'user_id' => $user->id,
            'amount' => round($total),
            'type' => 'Withdraw',
            'mode' => 'book',
        ]);

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
