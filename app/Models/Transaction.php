<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;

class Transaction extends Model
{
    protected $table='transactions';
    protected $fillable=['user_id','type','amount','mode'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public static function balance($userid){

           $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Deposit']??0)+($balances['win']??0)-($balances['Withdraw']??0)-($balances['booking']??0);
    }

    public static function totaldeposit($userid){

        $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Deposit']??0);
    }
//commission
    public static function totalcommission($userid){

        $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['commission']??0);
    }
    public static function totalprofitcommition($userid,$rate,$userrate){

            $commision=UserStat::where('user_id',$userid) ;
           $agenttotalbid= $commision->sum('digit0') + $commision->sum('digit1') +$commision->sum('digit2') +$commision->sum('digit3') +$commision->sum('digit4') + $commision->sum('digit5')+ $commision->sum('digit6')+$commision->sum('digit7') + $commision->sum('digit8') + $commision->sum('digit9');
        $total= $agenttotalbid*($rate-($userrate));

        return ($total??0);
    }
//end commission
    public static function totalwithdraw($userid){

        $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Withdraw']??0);
    }
}
