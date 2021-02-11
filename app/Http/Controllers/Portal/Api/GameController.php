<?php

namespace App\Http\Controllers\Portal\Api;

use App\Jobs\AdjustUserStats;
use App\Jobs\CreateCommissionBalance;
use App\Jobs\UpdateBookingBalance;
use App\Models\BidComment;
use App\Models\Game;
use App\Models\GameBook;
use App\Models\GamePrice;
use App\Models\Order;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//date_default_timezone_set('Asia/Kolkata');
class GameController extends Controller
{

    public function index(Request $request){
        $user=auth()->guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];
        $gamess=Game::where('isactive',1)->orderBy('close_date','desc')->orderBy('game_time', 'desc')->get();
        $games=array();
        foreach($gamess as $game){

            $date=$game->orginal;
            $time=$game->time;
            $datetime=$date." ".$time;
            // var_dump($datetime);die;
            $enddate=strtotime($datetime);
            $newdate=date('Y-m-d H:i:s');
            $current=strtotime($newdate);
            $remaining=($enddate-$current)*1000;

            if($current>=$enddate){
                $gam=Game::find($game->id);
                $gam->isactive=3;
                $gam->update();

            }else{


                $games[]=array(

                    'id'=>$game->id,
                    'name'=>$game->name,
                    'color_code'=>$game->color_code,
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

        }

//commission
//        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();
//        $ctotal = 0;
//        $cmc = 0;
//       if($agents->count()>0) {
//
//           foreach ($agents as $agent) {
//
//               $totalcommission = Transaction::totalcommission($agent->id);
//
//               $totalprofitcommission = Transaction::totalprofitcommition($agent->id, $agent->rate,$user->rate);
//               //var_dump($totalprofitcommission);die();
//               $cmc = $cmc + round($totalcommission, 2);
//               $ctotal = $ctotal + (round(($totalprofitcommission - $totalcommission), 2));
//           }
//           $ctotal = $ctotal + $cmc;
//       }
        $agents = User::with('childs.bids')
            ->where('parent_id', $user->id)
            ->whereNotNull('parent_id')
            ->orderBy('id', 'DESC')->get();
        $individual_commision=0;
        foreach($agents as $child){
            $individual_commision=$individual_commision+((($child->bids[0]->total)??0)*($child->rate-$user->rate));
        }

        $totalcommission = Transaction::totalcommission($user->id);
       // $ctotal=round(($individual_commision-$totalcommission),2);
        $ctotal=number_format(($individual_commision-$totalcommission), 2, '.', '');
      //  end commission

        $balance=Transaction::balance($user->id);
        $totaldeposit=Transaction::totaldeposit($user->id);
        $total=$totaldeposit;
        if(count($games)>0){
            return [
                'status'=>'success',
                'data'=>$games,
               // 'balance'=>round($balance,2),
                'balance'=>number_format($balance, 2, '.', ''),
                'username'=>$user->email,
                'total'=>$total,
                'commissiontotal'=>$ctotal,
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
        $date=$games->orginal;
        $time=$games->time;
        $datetime=$date." ".$time;
         //var_dump($datetime);die;
        $enddate=strtotime($datetime);
        $newdate=date('Y-m-d H:i:s');
        $current=strtotime($newdate);
        $remaining=($enddate-$current)*1000;

        if($current>=$enddate){
            $games->isactive=3;
            $games->update();

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
            'price'=>$user->rate,
            'remaining'=>$remaining,
        );
        $balance1=Transaction::balance($user->id);
       // $balance=round($balance1,2);
        $balance=number_format($balance1, 2, '.', '');
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
                'msg'=>'Please login to continue'
            ];
        $active=User::where('status',1)->where('id',$user->id)->first();
        if(!$active){
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];
        }

        if($user->status==0)
            return response()->json([
                'status'=>'failed',
                'msg'=>'Please contact to upline'
            ], 200);


        $games=Game::find($request->game_id);
        // $games=GamePrice::with('game')->where('agent_id',$user->parent_id)->where('game_id',$request->game_id)->first();

        $qty=  $request->bid_qty;

        $total=0;
        foreach($qty as $key=>$qt){
            if($qt>0){
                $total=$total+(($qt??0)*($user->rate??0));
            }
        }

        $balance1=Transaction::balance($user->id);
      //  $balance=round($balance1,2);
        $balance=number_format($balance1, 2, '.', '');

        if($balance < $total)
            return [
                'status'=>'failed',
                'msg'=>'You dont have sufficient balance to place this bid'
            ];


         $date=$games->orginal;
            $time=$games->time;
            $datetime=$date." ".$time;
            // var_dump($datetime);die;
            $enddate=strtotime($datetime);
            $newdate=date('Y-m-d H:i:s');
            $current=strtotime($newdate);
            $remaining=($enddate-$current)*1000;

            if($current>=$enddate){
            return [
                 'status'=>'failed',
                'message'=>'This Game Has been Expired'
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

        $unique_id=uniqid().rand(11111,99999);

        foreach($qty as $key=>$qt){
            if($qt>0){
                $book=  GameBook::create([
                    'user_id' => $user->id,
                    'attempt_id'=>$unique_id,
                    'order_id' => $bookorder,
                    'game_id' => $request->game_id,
                    'game_timing' =>$game['game_time'],
                    'close_date' =>$game['close_date'],
                    'game_price' =>$user->rate,
                    'name' => $game['name'],
                    'bid_number' => $game['degit'],
                    'bid_digit' => $key,
                    'bid_qty' => $qt,
                    'remark' => $request->comment,

                ]);
                $total=$total+($qt*$user->rate??'0');
            }

        }
        if(isset($request->comment)) {
            $createcomments = BidComment::create([
                'user_id' => $user->id,
                'game_id' => $request->game_id,
                'comment' => $request->comment

            ]);
        }
        $withdraw=Transaction::create([
            'user_id' => $user->id,
            'to_user_id' => $user->id,
          //  'amount' => round($total,2),
            'amount' => number_format($total, 2, '.', ''),
          //  'avl_balance' => round($balance,2)-round($total,2),
            'avl_balance' => number_format($balance, 2, '.', '')-number_format($total, 2, '.', ''),
            'type' => 'booking',
            'mode' => 'book',
        ]);

        if($book){
            dispatch(new AdjustUserStats($user, $games, $request->bid_qty))->onQueue('instant');
            dispatch(new UpdateBookingBalance($user, $request->bid_qty))->onQueue('instant');
            dispatch(new CreateCommissionBalance($user, $request->bid_qty))->onQueue('instant');
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
