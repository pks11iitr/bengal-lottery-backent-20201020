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

class HistoryCancelController extends Controller
{
    public function historycancel(Request $request, $id)
    {

        $user = Auth::guard('api')->user();
        if (!$user)
            return [
                'status' => 'failed',
                'message' => 'Please login to continue'
            ];

        $games = Game::find($id);
        $balance1 = Transaction::balance($user->id);
        $balance = round($balance1, 2);
        $bookgames = Order::with('bits')
            ->where('user_id', $user->id)
            ->where('game_id', $id)
            ->first();


        $totaldegits = 0;
        $digits_array = [];
        for ($i = 0; $i < 10; $i++)
            $digits_array[$i] = 0;

        foreach ($bookgames->bits as $bitposition) {
            $digits_array[$bitposition->bid_digit] = $digits_array[$bitposition->bid_digit] + $bitposition->bid_qty ?? 0;
            $totaldegits = $totaldegits + $bitposition->bid_qty ?? 0;

        }
        $withdraw = Transaction::create([
            'user_id' => $user->id,
            'to_user_id' => $user->id,
            'amount' => round($totaldegits, 2),
            'avl_balance' => round($balance, 2) + round($totaldegits, 2),
            'type' => 'booking',
            'mode' => 'cancel degits balance',
        ]);
        if ($digits_array) {
            dispatch(new AdjustUserStatsCancel($user, $games, $digits_array))->onQueue('instant');
            dispatch(new UpdateBookingBalanceCancel($user, $digits_array))->onQueue('instant');
            dispatch(new CreateCommissionBalanceCancel($user, $digits_array))->onQueue('instant');
            $gamebook=GameBook::where('user_id',$user->id)->where('game_id',$id)->get();
            foreach ($gamebook as $dgame){
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

    }
}
