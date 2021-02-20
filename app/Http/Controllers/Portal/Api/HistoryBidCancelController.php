<?php

namespace App\Http\Controllers\Portal\Api;

use App\Jobs\AdjustUserStatsCancel;
use App\Jobs\CreateCommissionBalanceCancel;
use App\Jobs\UpdateBookingBalanceCancel;
use App\Models\Game;
use App\Models\GameBook;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HistoryBidCancelController extends Controller
{
    public function historyBidcancel(Request $request, $id,$attempt_id)
    {

        $user = Auth::guard('api')->user();
        if (!$user)
            return [
                'status' => 'failed',
                'message' => 'Please login to continue'
            ];

        $games = Game::where('isactive', 1)->where('id',$id)->first();

        if ($games) {
            $closedate = $games->close_date;
            $closetime = $games->game_time;
            $closedatetime = $closedate . " " . $closetime;
            $closedatevalue = strtotime($closedatetime);

            $currentdate = date('Y-m-d H:i:s');
            $currentvalue = strtotime($currentdate);

            if ($currentvalue >= $closedatevalue) {
                return [
                    'status' => 'failed',
                    'msg' => 'Bid Can Not Caneclled'
                ];
            }

            $balance1 = Transaction::balance($user->id);
            //$balance = round($balance1, 2);
            $balance = number_format($balance1, 2, '.', '');
      $bookgames = Order::where('user_id', $user->id)
                ->where('game_id', $id)
                ->first();
 $bidcancel=GameBook::where('attempt_id',$attempt_id)->where('user_id',$user->id)->get();

            $totaldegits = 0;
            $digits_array = [];
            for ($i = 0; $i < 10; $i++)
                $digits_array[$i] = 0;

            foreach ($bidcancel as $bitposition) {
                $digits_array[$bitposition->bid_digit] = $digits_array[$bitposition->bid_digit] + $bitposition->bid_qty ?? 0;
                $totaldegits = $totaldegits + ($bitposition->bid_qty*$user->rate??'0');

            }
            // var_dump($digits_array);die();
            $withdraw = Transaction::create([
                'user_id' => $user->id,
                'to_user_id' => $user->id,
                // 'amount' => round($totaldegits, 2),
                'amount' => number_format($totaldegits, 2, '.', ''),
                //  'avl_balance' => round($balance, 2) + round($totaldegits, 2),
                'avl_balance' => number_format($balance, 2, '.', '') + number_format($totaldegits, 2, '.', ''),
                'type' => 'Deposit',
                'mode' => 'cancel degits balance',
            ]);
            if ($digits_array) {
                dispatch(new AdjustUserStatsCancel($user, $games, $digits_array))->onQueue('instant');
                dispatch(new UpdateBookingBalanceCancel($user, $digits_array))->onQueue('instant');
                dispatch(new CreateCommissionBalanceCancel($user, $digits_array))->onQueue('instant');
                $gamebook=GameBook::where('attempt_id',$request->attempt_id)->where('user_id',$user->id)->get();
                foreach ($gamebook as $dgame) {
                    $dgame->delete();
                }
                return [
                    'status' => 'success',
                    'msg' => 'success',
                ];
            } else {
                return [
                    'status' => 'failed',
                    'msg' => 'some error occoured'
                ];
            }

        }else{
            return [
                'status' => 'failed',
                'msg' => 'Bid Can Not Caneclled'
            ];
        }
    }

}
