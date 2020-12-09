<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Order;
use App\Models\GameBook;
use App\Models\Game;
use App\Models\Transaction;
use App\Models\UserStat;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DownlinegamehistoryController extends Controller
{

    public function index(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user)
            return [
                'status' => 'failed',
                'message' => 'Please login to continue'
            ];
        $t0 = 0;
        $t1 = 0;
        $t2 = 0;
        $t3 = 0;
        $t4 = 0;
        $t5 = 0;
        $t6 = 0;
        $t7 = 0;
        $t8 = 0;
        $t9 = 0;
        $finaltotaltan = 0;
        $finaltotalticket = 0;
        $finaltotalwin = 0;
        $win0 = 0;
        $win1 = 0;
        $win2 = 0;
        $win3 = 0;
        $win4 = 0;
        $win5 = 0;
        $win6 = 0;
        $win7 = 0;
        $win8 = 0;
        $win9 = 0;
        $games = Game::whereNotIn('isactive', [0]);

        $games = $games->where('close_date', $request->close_date)->get();
        foreach ($games as $game) {
            $totalbid = UserStat::where('user_id', $request->agent_id)->where('game_id', $game->id)->first();

            $game->totaltan = 0;
            $game->totalticket = 0;
            $game->totalwin = 0;
            if ($totalbid) {
                $t0 = $t0 + $totalbid->digit0 ?? 0;
                $t1 = $t1 + $totalbid->digit1 ?? 0;
                $t2 = $t2 + $totalbid->digit2 ?? 0;
                $t3 = $t3 + $totalbid->digit3 ?? 0;
                $t4 = $t4 + $totalbid->digit4 ?? 0;
                $t5 = $t5 + $totalbid->digit5 ?? 0;
                $t6 = $t6 + $totalbid->digit6 ?? 0;
                $t7 = $t7 + $totalbid->digit7 ?? 0;
                $t8 = $t8 + $totalbid->digit8 ?? 0;
                $t9 = $t9 + $totalbid->digit9 ?? 0;
                $finaltotaltan = $finaltotaltan + min($totalbid->digit0, $totalbid->digit1, $totalbid->digit2, $totalbid->digit3, $totalbid->digit4, $totalbid->digit5, $totalbid->digit6, $totalbid->digit7, $totalbid->digit8, $totalbid->digit9);

                $finaltotalticket = $finaltotalticket + ($totalbid->digit0 + $totalbid->digit1 + $totalbid->digit2 + $totalbid->digit3 + $totalbid->digit4 + $totalbid->digit5 + $totalbid->digit6 + $totalbid->digit7 + $totalbid->digit8 + $totalbid->digit9);
                $wondegit = Game::where('id', $game->id)->whereNotNull('bid_qty')->first();
                if ($wondegit) {
                    if ($wondegit->bid_qty == 0) {
                        $win0 = $totalbid->digit0 ?? 0;
                    } elseif ($wondegit->bid_qty == 1) {
                        $win1 = $totalbid->digit1 ?? 0;
                    } elseif ($wondegit->bid_qty == 2) {
                        $win2 = $totalbid->digit2 ?? 0;
                    } elseif ($wondegit->bid_qty == 3) {
                        $win3 = $totalbid->digit3 ?? 0;
                    } elseif ($wondegit->bid_qty == 4) {
                        $win4 = $totalbid->digit4 ?? 0;
                    } elseif ($wondegit->bid_qty == 5) {
                        $win5 = $totalbid->digit5 ?? 0;
                    } elseif ($wondegit->bid_qty == 6) {
                        $win6 = $totalbid->digit6 ?? 0;
                    } elseif ($wondegit->bid_qty == 7) {
                        $win7 = $totalbid->digit7 ?? 0;
                    } elseif ($wondegit->bid_qty == 8) {
                        $win8 = $totalbid->digit8 ?? 0;
                    } elseif ($wondegit->bid_qty == 9) {
                        $win9 = $totalbid->digit9 ?? 0;
                    }
                }
                $finaltotalwin = $finaltotalwin + max($win0, $win1, $win2, $win3, $win4, $win5, $win6, $win7, $win8, $win9);

                $game->totaltan = min($totalbid->digit0, $totalbid->digit1, $totalbid->digit2, $totalbid->digit3, $totalbid->digit4, $totalbid->digit5, $totalbid->digit6, $totalbid->digit7, $totalbid->digit8, $totalbid->digit9);
                $game->totalticket = ($totalbid->digit0 + $totalbid->digit1 + $totalbid->digit2 + $totalbid->digit3 + $totalbid->digit4 + $totalbid->digit5 + $totalbid->digit6 + $totalbid->digit7 + $totalbid->digit8 + $totalbid->digit9);
                $game->totalwin = max($win0, $win1, $win2, $win3, $win4, $win5, $win6, $win7, $win8, $win9);
            }
        }

        $total = array(
            'finaltotaltan' => $finaltotaltan,
            'finaltotalticket' => $finaltotalticket,
            'finaltotalwin' => $finaltotalwin,
        );

        if ($games->count() > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
                'data' => compact('games', 'total')
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => 'Please Select Agent and Game Date'
            ];
        }
    }

    public function agentlist(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user)
            return [
                'status' => 'failed',
                'message' => 'Please login to continue'
            ];

            $agents=User::where('parent_id',$user->id)->whereNotNull('parent_id')->select('id','email','parent_id','rate','status','account')->get();


        if ($agents->count() > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
                'data' => compact('agents')
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => 'No Record Found'
            ];
        }
    }

    public function agentcommission(Request $request)
    {
        $user = Auth::guard('api')->user();
        if (!$user)
            return [
                'status' => 'failed',
                'message' => 'Please login to continue'
            ];

        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();

        $total = 0;$cmc=0;
        foreach ($agents as $agent) {
            $totalcommission = Transaction::totalcommission($agent->id);
            $totalprofitcommission = Transaction::totalprofitcommition($agent->id, $agent->rate,$user->rate);
            $cmc=$cmc+round($totalcommission,2);
            $total = $total + ( round(($totalprofitcommission-$totalcommission),2));
        }
        $total=$total+$cmc;

        if ($agents->count() > 0) {
            return [
                'status' => 'success',
                'message' => 'success',
                'data' => $total
            ];
        } else {
            return [
                'status' => 'failed',
                'message' => 'No Record Found'
            ];
        }
    }

}
