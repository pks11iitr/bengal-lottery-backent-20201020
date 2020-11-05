<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Order;
use App\Models\GameBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class BookingHistoryController extends Controller
{

    public function index(Request $request){
       $user=Auth::guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];

        $bookgames=Order::where('user_id',$user->id)->get();
        foreach ($bookgames as $book){
            $book->bidlist=GameBook::where('user_id',$user->id)->where('game_id',$book->game_id)->groupBy('created_at')->select(DB::raw('GROUP_CONCAT(bid_qty) AS qty'),DB::raw('GROUP_CONCAT(bid_digit) AS degqty'),DB::raw('GROUP_CONCAT(id) AS ids'), 'created_at')->get();
            $totalbid=GameBook::where('user_id',$user->id)->where('game_id',$book->game_id)->get();
            $totalqty=0;$totalqty1=0;$totalqty2=0;$totalqty3=0;$totalqty4=0;$totalqty5=0;
            $totalqty6=0;$totalqty7=0;$totalqty8=0;$totalqty9=0;
            foreach ($totalbid as $bid){
                if($bid->bid_digit==0){
                    $totalqty=$totalqty+($bid->bid_qty*$bid->game_price);

                }elseif($bid->bid_digit==1){
                    $totalqty1=$totalqty1+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==2){
                    $totalqty2=$totalqty2+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==3){
                    $totalqty3=$totalqty3+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==4){
                    $totalqty4=$totalqty4+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==5){
                    $totalqty5=$totalqty5+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==6){
                    $totalqty6=$totalqty6+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==7){
                    $totalqty7=$totalqty7+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==8){
                    $totalqty8=$totalqty8+($bid->bid_qty*$bid->game_price);
                }elseif($bid->bid_digit==9){
                    $totalqty9=$totalqty9+($bid->bid_qty*$bid->game_price);
                }

            }
            $book->totalbidqty=array(
                'totalqty'=>$totalqty,
                'totalqty1'=>$totalqty1,
                'totalqty2'=>$totalqty2,
                'totalqty3'=>$totalqty3,
                'totalqty4'=>$totalqty4,
                'totalqty5'=>$totalqty5,
                'totalqty6'=>$totalqty6,
                'totalqty7'=>$totalqty7,
                'totalqty8'=>$totalqty8,
                'totalqty9'=>$totalqty9,
            );

        }


//        ->groupBy('game_id')->select(DB::raw('GROUP_CONCAT(name) AS id'), 'game_id')
        if($bookgames->count()>0){
            return [
                'status'=>'success',
                'msg'=>'success',
                'data'=>compact('bookgames')
            ];
        }else{
            return [
                'status'=>'failed',
                'msg'=>'No Record Found'
            ];
        }
    }

//
//    public function gamedetails(Request $request){
//        //var_dump($request->game_id); die;
//        $game=Game::find($request->game_id);
//
//        $balance=1500;
//        $total=2500;
//        $date=date('Y-m-d H:i:s');
//        $cdate=date('d M Y', strtotime($date));
//        if($game){
//            return [
//                'status'=>'success',
//                'data'=>compact('game','balance','total','cdate')
//            ];
//        }else{
//            return [
//                'status'=>'No Record Found',
//                'code'=>'402'
//            ];
//        }
//    }

//    public function gamebooking(Request $request){
//        //var_dump($request->game_id); die;
//        $game=Game::find($request->game_id);
//        $digit=  $request->bid_digit;
//        $qty=  $request->bid_qty;
//        foreach($digit as $key=>$dig){
//            $book=  GameBook::create([
//                'user_id' => 5,
//                'game_id' => $request->game_id,
//                'game_timing' =>$game->game_time,
//                'close_date' =>$game->close_date,
//                'name' => $game->name,
//                'bid_digit' => $dig,
//                'bid_qty' => $qty[$key],
//
//            ]);
//        }
//        if($book){
//            return [
//                'status'=>'success',
//                'msg'=>'success',
//            ];
//        }else{
//            return [
//                'status'=>'failed',
//                'msg'=>'some error occoured'
//            ];
//        }
//    }


}
