<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    protected $table='user_commission';
    protected $fillable=['total_commission','user_id'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public static function avl_commission($parent_id){

        $avlcommission =   Commission::where('user_id',$parent_id)->first();
        return $avlcommission->total_commission??0;
    }
}
