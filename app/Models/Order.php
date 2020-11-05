<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Order extends Model
{
    protected $table='orders';
    protected $fillable=['name','user_id','game_id','game_timing','close_date','status','game_price','winning_digit','winning_amount'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function bits(){
        return $this->belongsTo('App\Models\GameBook');
    }
}
