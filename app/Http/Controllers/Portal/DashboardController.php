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
            ->limit(10)->get();
        $totalgames = $games->count();

        //commission
        $agents = User::with('childs.bids')->where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id', 'DESC')->get();

        $total = 0;$cmc=0;
        foreach ($agents as $agent) {
            $totalcommission = Transaction::totalcommission($agent->id);

            $individual_commision=0;
            foreach($agent->childs as $child){
                $individual_commision=$individual_commision+((($child->bids[0]->total)??0)*($child->rate-$agent->rate));
            }
           // $totalprofitcommission = Transaction::totalprofitcommition($agent->id, $agent->rate, $user->rate);
            $cmc=$cmc+round($totalcommission,2);
          //  $total = $total + ( round(($individual_commision),2));
        }
       $total=$individual_commision-$cmc;
        //end commission

        return view('portal.dashboard', compact('agents', 'totalagent', 'games', 'totalgames', 'total'));
    }

}
