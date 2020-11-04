<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\MappedCode;
use App\QrCodes;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard(Request $request){

        $user=auth()->user();
        $agents=User::where('parent_id', $user->id)
            ->orderBy('id','DESC')
            ->limit(10)
        ->get();
        $ag=User::where('parent_id', $user->id)
            ->orderBy('id','DESC')
            ->get();
        $totalagent=$ag->count();
        $games=Game::orderBy('id','DESC')
            ->get();
        $totalgames=$games->count();
      //  $qrcode=QrCodes::where('user_id', $user->id)->sum('total');
//        $mappedqr=MappedCode::where('user_id', $user->id)->sum('total');
//        $skus=CompanyProducts::where('user_id', $user->id)
//            ->distinct('sku')->count();
//        $recentproducts=CompanyProducts::where('user_id',$user->id)
//            ->orderBy('id', 'desc')->paginate('10');
//        $recentmapped=MappedCode::with(['product', 'manufacturer'])->where('user_id', $user->id)
//            ->orderBy('id', 'desc')
//            ->paginate(10);

        return view('portal.dashboard', compact('agents','totalagent','games','totalgames'));
    }
}
