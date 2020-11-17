<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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

        return ($balances['Deposit']??0)-($balances['Withdraw']??0);
    }

    public static function totaldeposit($userid){

        $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Deposit']??0);
    }

    public static function totalwithdraw($userid){

        $wallet=Transaction::where('user_id', $userid)->select(DB::raw('sum(amount) as total'), 'type')->groupBy('type')->get();
        $balances=[];
        foreach($wallet as $w){
            $balances[$w->type]=$w->total;
        }

        return ($balances['Withdraw']??0);
    }
}
