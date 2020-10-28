<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Game;
use App\Models\GameBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class BookingHistoryController extends Controller
{

    public function index(Request $request){
      /* $user=auth()->guard('api')->user();
        if(!$user)
            return [
                'status'=>'failed',
                'message'=>'Please login to continue'
            ];
        var_dump($user->id);die();*/
        $bookgames=GameBook::where('user_id',5)->get();
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


    public function gamedetails(Request $request){
        //var_dump($request->game_id); die;
        $game=Game::find($request->game_id);
        $balance=1500;
        $total=2500;
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
        //var_dump($request->game_id); die;
        $game=Game::find($request->game_id);
        $digit=  $request->bid_digit;
        $qty=  $request->bid_qty;
        foreach($digit as $key=>$dig){
            $book=  GameBook::create([
                'user_id' => 5,
                'game_id' => $request->game_id,
                'game_timing' =>$game->game_time,
                'close_date' =>$game->close_date,
                'name' => $game->name,
                'bid_digit' => $dig,
                'bid_qty' => $qty[$key],

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
