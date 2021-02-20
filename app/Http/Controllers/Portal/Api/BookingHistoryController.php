<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Order;
use App\Models\GameBook;
use App\Models\Game;
use App\Models\Transaction;
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
        $remaining_balance=Transaction::balance($user->id);
        $totaldeposit=Transaction::totaldeposit($user->id);
        $total=$totaldeposit;
        if($request->game_id){
            $bookgames=Order::with('game')->where('user_id',$user->id)->where('game_id',$request->game_id)->get();

            foreach ($bookgames as $book){
            $book->gamestatus=$book->game->isactive;
                $book->bidlist=GameBook::where('user_id',$user->id)
                ->where('game_id',$book->game_id)
                ->groupBy('attempt_id')
                ->select(DB::raw('GROUP_CONCAT(bid_digit order by bid_digit asc) AS bid_digit'),DB::raw('GROUP_CONCAT(bid_qty order by bid_digit asc) AS bid_qty'),DB::raw('GROUP_CONCAT(game_price order by bid_digit asc) AS game_price'),DB::raw('GROUP_CONCAT(remark order by bid_digit asc ) AS remark'), 'attempt_id')
                ->get();

                $totalbid=GameBook::where('user_id',$user->id)
                ->where('game_id',$book->game_id)
                ->get();
                $token=0;
                $winamt=0;
                $winresult=GameBook::where('user_id',$user->id)->where('game_id',$book->game_id)->where('status','Won')->select(DB::raw('SUM(bid_qty) as wintoken'),'winning_amount')->groupBy('winning_amount')->get();
                if($winresult){
                    foreach ($winresult as $res){
                        $token=  $token+$res->wintoken;
                        $winamt=$res->winning_amount??0;
                    }
                    $book->totalwin_amount=$token*$winamt;
                    $book->totalwin_token=$token;

                }
                $totaltoken=0;$totaltoken1=0;$totaltoken2=0;$totaltoken3=0;$totaltoken4=0;$totaltoken5=0;$totaltoken6=0;$totaltoken7=0;$totaltoken8=0;$totaltoken9=0;

                foreach ($totalbid as $bid){

                    if($bid->bid_digit==0){

                        $status['status0']=$bid->status??'';
                        $totaltoken=$totaltoken+$bid->bid_qty;

                    }elseif($bid->bid_digit==1){

                        $status['status1']=$bid->status??'';
                        $totaltoken1=$totaltoken1+$bid->bid_qty;

                    }elseif($bid->bid_digit==2){

                        $status['status2']=$bid->status??'';
                        $totaltoken2=$totaltoken2+$bid->bid_qty;

                    }elseif($bid->bid_digit==3){

                        $status['status3']=$bid->status??'';
                        $totaltoken3=$totaltoken3+$bid->bid_qty;

                    }elseif($bid->bid_digit==4){

                        $status['status4']=$bid->status;
                        $totaltoken4=$totaltoken4+$bid->bid_qty;

                    }elseif($bid->bid_digit==5){

                        $status['status5']=$bid->status;
                        $totaltoken5=$totaltoken5+$bid->bid_qty;

                    }elseif($bid->bid_digit==6){

                        $status['status6']=$bid->status;
                        $totaltoken6=$totaltoken6+$bid->bid_qty;

                    }elseif($bid->bid_digit==7){

                        $status['status7']=$bid->status;
                        $totaltoken7=$totaltoken7+$bid->bid_qty;

                    }elseif($bid->bid_digit==8){

                        $status['status8']=$bid->status;
                        $totaltoken8=$totaltoken8+$bid->bid_qty;

                    }elseif($bid->bid_digit==9){

                        $status['status9']=$bid->status;
                        $totaltoken9=$totaltoken9+$bid->bid_qty;

                    }

                }

                $book->totalticket=array(
                    'totaltoken'=>$totaltoken,
                    'totaltoken1'=>$totaltoken1,
                    'totaltoken2'=>$totaltoken2,
                    'totaltoken3'=>$totaltoken3,
                    'totaltoken4'=>$totaltoken4,
                    'totaltoken5'=>$totaltoken5,
                    'totaltoken6'=>$totaltoken6,
                    'totaltoken7'=>$totaltoken7,
                    'totaltoken8'=>$totaltoken8,
                    'totaltoken9'=>$totaltoken9,
                );
                $book->finaltotalticket=$totaltoken+$totaltoken1+$totaltoken2+$totaltoken3+$totaltoken4+$totaltoken5+$totaltoken6+$totaltoken7+$totaltoken8+$totaltoken9;
                $book->status=array(
                    'status0'=>$status['status0']??'',
                    'status1'=>$status['status1']??'',
                    'status2'=>$status['status2']??'',
                    'status3'=>$status['status3']??'',
                    'status4'=>$status['status4']??'',
                    'status5'=>$status['status5']??'',
                    'status6'=>$status['status6']??'',
                    'status7'=>$status['status7']??'',
                    'status8'=>$status['status8']??'',
                    'status9'=>$status['status9']??'',
                );

            }

        }else{
            return [
                'status'=>'failed',
                'msg'=>'Parameter Missing'
            ];
        }

        if($bookgames->count()>0){
            return [
                'status'=>'success',
                'msg'=>'success',
              //  'remaining_balance'=>round($remaining_balance,2),
                'remaining_balance'=>number_format($remaining_balance, 2, '.', ''),

                'data'=>compact('bookgames')
            ];
        }else{
            return [
                'status'=>'failed',
                'msg'=>'No Record Found'
            ];
        }
    }

/*    public function historygames(Request $request){
        $user=auth()->guard('api')->user();
        // if(!$user)
        //     return [
        //         'status'=>'failed',
        //         'message'=>'Please login to continue'
        //     ];
        if($user){
            $game=Order::where('user_id',$user->id)->select('game_id','name')->orderBy('id','DESC')->get();
        }else{
            $game=Game::whereNotIn('isactive',[0])->select('id as game_id','name')->orderBy('id','DESC')->get();
        }
        if($game->count()>0){
            return [
                'status'=>'success',
                'data'=>compact('game'),
            ];
        }else{
            return [
                'status'=>'No Record Found',
                'code'=>'402'
            ];
        }
    }*/
    public function historygame(Request $request){
        $user=auth()->guard('api')->user();
        // if(!$user)
        //     return [
        //         'status'=>'failed',
        //         'message'=>'Please login to continue'
        //     ];
       // $currentdate=strtotime(date("Y-m-d"));
       // $closedate=date("Y-m-d",strtotime('-7 day',$currentdate));
       // $orderclosedate=date("d M Y",strtotime('-7 day',$currentdate));
        if($user){
            $games=Order::whereHas('game', function($game){
                    $game->where('game.days',0)
                        ->orWhere(function($game){
                            $game->where('game.days','>',0)
                                ->where(DB::raw('DATEDIFF("'.date('Y-m-d').'",game.close_date)'),'<', DB::raw('game.days'));
                        });
                })
                ->where('user_id',$user->id)
                ->select('game_id','name','close_date as enddate')
                //->whereDate('close_date', '>=', $orderclosedate)
                ->orderBy('id','DESC')
                ->get();
        }else{
            //DB::enableQueryLog();
            $games=Game::select('id as game_id','name','close_date as enddate','days','game_time')
                //->whereDate('close_date', '>=', $closedate)
                ->where(function($query){
                    $query->where('days',0)
                        ->orWhere(function($query){
                            $query->where('days','>',0)
                                ->where(DB::raw('DATEDIFF("'.date('Y-m-d').'",close_date)'),'<', DB::raw('days'));
                        });
                })
                ->whereNotIn('isactive',[0])
                ->orderBy('id','DESC')
                ->get();
            //dd(DB::getQueryLog());
        }
        $game=$games;
//        $game=array();
//        foreach ($games as $g){
//
//            if($g->days > 0){
//
//                $closedate=strtotime(date("Y-m-d",strtotime('+'.$g->days.' day',strtotime($g->enddate))));
//                $currentdate=strtotime(date("Y-m-d"));
//
//                if($currentdate<$closedate){
//                    $game[]=array(
//                        'game_id'=>$g->game_id,
//                        'name'=>$g->name,
//                        'orginal'=>$g->orginal,
//                        'time'=>$g->time,
//                    );
//                }
//
//            }else{
//                $game[]=array(
//                    'game_id'=>$g->game_id,
//                    'name'=>$g->name,
//                    'orginal'=>$g->orginal,
//                    'time'=>$g->time,
//                );
//            }
//
//        }
        if(count($game)>0){
            return [
                'status'=>'success',
                'data'=>compact('game'),
            ];
        }else{
            return [
                'status'=>'No Record Found',
                'code'=>'402'
            ];
        }
    }

    public function gameresult(Request $request){
        $user=auth()->guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];

        $game=Order::where('user_id',$user->id)->whereNotNull('draw_result')->select('game_id','name','draw_result')->get();
        if($game->count()>0){
            return [
                'status'=>'success',
                'data'=>compact('game'),
            ];
        }else{
            return [
                'status'=>'No Record Found',
                'code'=>'402'
            ];
        }
    }

}
