<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $table='user_balances';
    protected $fillable=['amount','user_id'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public static function update_deposit_balance($parent_id,$child_id,$amount){

      $senderbalance=   Balance::where('user_id',$parent_id)->first();
      $reciverbalance=   Balance::where('user_id',$child_id)->first();
//       if(!$senderbalance){
//           $senderbalance= Balance::create([
//               'user_id' => $senderid,
//               'amount' => round($amount, 2),
//
//           ]);
//       }else{
        /*if($senderbalance){
            $senderbalance->amount=$senderbalance->amount - round($amount, 2);
            $senderbalance->save();
        }*/

     //  }
       if(!$reciverbalance){
           $reciverbalance= Balance::create([
               'user_id' => $child_id,
              // 'amount' => round($amount, 2),
               'amount' => number_format($amount, 2, '.', ''),
           ]);
       }else{
         //  $reciverbalance->amount=$reciverbalance->amount + round($amount, 2);
           $reciverbalance->amount=$reciverbalance->amount + number_format($amount, 2, '.', '');
           $reciverbalance->save();
       }
    }

    public static function update_withdraw_balance($withdrawer_id,$parent_id,$amount){

        $senderbalance=   Balance::where('user_id',$withdrawer_id)->first();
        $reciverbalance=   Balance::where('user_id',$parent_id)->first();
       /* if(!$senderbalance){
            $senderbalance= Balance::create([
                'user_id' => $withdrawer_id,
                'amount' => round($amount, 2),

            ]);
        }else{*/
        if($senderbalance){
            //$senderbalance->amount=$senderbalance->amount-round($amount, 2);
            $senderbalance->amount=$senderbalance->amount-number_format($amount, 2, '.', '');
            $senderbalance->save();
        }

       // }
//        if(!$reciverbalance){
//            $reciverbalance= Balance::create([
//                'user_id' => $parent_id,
//                'amount' => round($amount, 2),
//            ]);
//        }else{
//            $reciverbalance->amount=$reciverbalance->amount + round($amount, 2);
//            $reciverbalance->save();
//        }
    }

//    public static function commission_balance($parent_id,$child_id,$amount){
//
//        $senderbalance=   Balance::where('user_id',$parent_id)->first();
//       if(!$senderbalance){
//
//           $senderbalance= Balance::create([
//               'user_id' => $parent_id,
//               'amount' => round($amount, 2),
//
//           ]);
//
//       }else{
//           $senderbalance->amount=$senderbalance->amount+round($amount, 2);
//           $senderbalance->save();
//       }
//    }

    public static function avl_balance($parent_id){

    $avabalance =   Balance::where('user_id',$parent_id)->first();
    return $avabalance->amount??0;
    }

}
