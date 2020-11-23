<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Order;
use App\Models\GameBook;
use App\Models\Transaction;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class DownlineController extends Controller
{

    public function index(Request $request){
        $user=Auth::guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];

        if($request->game_id){
            $t0 = 0; $t1 = 0; $t2 = 0; $t3 = 0; $t4 = 0; $t5 = 0; $t6 = 0; $t7 = 0; $t8 = 0; $t9 = 0;$finaltotaltan=0;$finaltotalticket=0;$finaltotalwin=0;
            $agents=User::where('parent_id',$user->id)->select('id','email')->get();
foreach ($agents as $useragent) {

    $totalbid = GameBook::where('user_id', $useragent->id)->where('game_id', $request->game_id)->get();

    $totaltoken = 0;
    $totaltoken1 = 0;
    $totaltoken2 = 0;
    $totaltoken3 = 0;
    $totaltoken4 = 0;
    $totaltoken5 = 0;
    $totaltoken6 = 0;
    $totaltoken7 = 0;
    $totaltoken8 = 0;
    $totaltoken9 = 0;

    $totaltoken00 = 0;
    $totaltoken11 = 0;
    $totaltoken21 = 0;
    $totaltoken31 = 0;
    $totaltoken41 = 0;
    $totaltoken51 = 0;
    $totaltoken61 = 0;
    $totaltoken71 = 0;
    $totaltoken81 = 0;
    $totaltoken91 = 0;

    foreach ($totalbid as $bid) {

        if ($bid->bid_digit == 0) {
            $totaltoken = $totaltoken + $bid->bid_qty;
        } elseif ($bid->bid_digit == 1) {
            $totaltoken1 = $totaltoken1 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 2) {
            $totaltoken2 = $totaltoken2 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 3) {
            $totaltoken3 = $totaltoken3 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 4) {
            $totaltoken4 = $totaltoken4 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 5) {
            $totaltoken5 = $totaltoken5 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 6) {
            $totaltoken6 = $totaltoken6 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 7) {
            $totaltoken7 = $totaltoken7 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 8) {
            $totaltoken8 = $totaltoken8 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 9) {
            $totaltoken9 = $totaltoken9 + $bid->bid_qty;
        }

        if ($bid->bid_digit == 0 && $bid->status == 'Won') {
            $totaltoken00 = $totaltoken00 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 1 && $bid->status == 'Won') {
            $totaltoken11 = $totaltoken11 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 2 && $bid->status == 'Won') {
            $totaltoken21 = $totaltoken21 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 3 && $bid->status == 'Won') {
            $totaltoken31 = $totaltoken31 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 4 && $bid->status == 'Won') {
            $totaltoken41 = $totaltoken41 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 5 && $bid->status == 'Won') {
            $totaltoken51 = $totaltoken51 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 6 && $bid->status == 'Won') {
            $totaltoken61 = $totaltoken61 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 7 && $bid->status == 'Won') {
            $totaltoken71 = $totaltoken71 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 8 && $bid->status == 'Won') {
            $totaltoken81 = $totaltoken81 + $bid->bid_qty;
        } elseif ($bid->bid_digit == 9 && $bid->status == 'Won') {
            $totaltoken91 = $totaltoken91 + $bid->bid_qty;
        }


    }
    $t0=$t0+$totaltoken;
    $t1=$t1+$totaltoken1;
    $t2=$t2+$totaltoken2;
    $t3=$t3+$totaltoken3;
    $t4=$t4+$totaltoken4;
    $t5=$t5+$totaltoken5;
    $t6=$t6+$totaltoken6;
    $t7=$t7+$totaltoken7;
    $t8=$t8+$totaltoken8;
    $t9=$t9+$totaltoken9;
    $finaltotaltan =$finaltotaltan+ min($totaltoken, $totaltoken1, $totaltoken2, $totaltoken3, $totaltoken4, $totaltoken5, $totaltoken6, $totaltoken7, $totaltoken8, $totaltoken9);
    $finaltotalticket=$finaltotalticket+ ($totaltoken + $totaltoken1 + $totaltoken2 + $totaltoken3 + $totaltoken4 + $totaltoken5 + $totaltoken6 + $totaltoken7 + $totaltoken8 + $totaltoken9);
    $finaltotalwin=$finaltotalwin+ max($totaltoken00, $totaltoken11, $totaltoken21, $totaltoken31, $totaltoken41, $totaltoken51, $totaltoken61, $totaltoken71, $totaltoken81, $totaltoken91);

    $useragent->ticket = array(
        'totaltoken' => $totaltoken,
        'totaltoken1' => $totaltoken1,
        'totaltoken2' => $totaltoken2,
        'totaltoken3' => $totaltoken3,
        'totaltoken4' => $totaltoken4,
        'totaltoken5' => $totaltoken5,
        'totaltoken6' => $totaltoken6,
        'totaltoken7' => $totaltoken7,
        'totaltoken8' => $totaltoken8,
        'totaltoken9' => $totaltoken9,
        'totaltan' => min($totaltoken, $totaltoken1, $totaltoken2, $totaltoken3, $totaltoken4, $totaltoken5, $totaltoken6, $totaltoken7, $totaltoken8, $totaltoken9),
        'totalticket' => ($totaltoken + $totaltoken1 + $totaltoken2 + $totaltoken3 + $totaltoken4 + $totaltoken5 + $totaltoken6 + $totaltoken7 + $totaltoken8 + $totaltoken9),
        'totalwin' => max($totaltoken00, $totaltoken11, $totaltoken21, $totaltoken31, $totaltoken41, $totaltoken51, $totaltoken61, $totaltoken71, $totaltoken81, $totaltoken91),
    );

}
            $total=array(
                'total0'=>$t0,
                'total1'=>$t1,
                'total2'=>$t2,
                'total3'=>$t3,
                'total4'=>$t4,
                'total5'=>$t5,
                'total6'=>$t6,
                'total7'=>$t7,
                'total8'=>$t8,
                'total9'=>$t9,
                'finaltotaltan'=>$finaltotaltan,
                'finaltotalticket'=>$finaltotalticket,
                'finaltotalwin'=>$finaltotalwin,
            );
        }else{
            return [
                'status'=>'failed',
                'msg'=>'Parameter Missing'
            ];
        }

        if($agents->count()>0){
            return [
                'status'=>'success',
                'msg'=>'success',
                'data'=>compact('agents','total')
            ];
        }else{
            return [
                'status'=>'failed',
                'msg'=>'No Record Found'
            ];
        }
    }


}
