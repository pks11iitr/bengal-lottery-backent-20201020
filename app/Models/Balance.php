<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table='user_balances';
    protected $fillable=['amount','user_id'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public static function updatewinbalance($senderid,$reciverid,$amount){

      $senderbalance=   Balance::where('user_id',$senderid)->first();
      $senderbalance=   Balance::where('user_id',$reciverid)->first();
       if(!$senderbalance){
        //Balance::
       }
       return ;
    }
}
