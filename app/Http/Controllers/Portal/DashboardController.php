<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\MappedCode;
use App\Models\Transaction;
use App\Models\UserStat;
use App\QrCodes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        $user = auth()->user();
        $agents = User::where('parent_id', $user->id)
            ->orderBy('id', 'DESC')
            ->limit(10)
            ->get();
        $ag = User::where('parent_id', $user->id)
            ->orderBy('id', 'DESC')
            ->get();
        $totalagent = $ag->count();
        $games = Game::orderBy('id', 'DESC')
            ->get();
        $totalgames = $games->count();
        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();

        //commission
        $total = 0;$cmc=0;
        foreach ($agents as $agent) {
            $totalcommission = Transaction::totalcommission($agent->id);
            $totalprofitcommission = Transaction::totalprofitcommition($agent->id, $agent->rate);
            $cmc=$cmc+round($totalcommission,2);
            $total = $total + ( round(($totalprofitcommission-$totalcommission),2));
        }
       $total=$total+$cmc;
        //end commission

        return view('portal.dashboard', compact('agents', 'totalagent', 'games', 'totalgames', 'total'));
    }

}
