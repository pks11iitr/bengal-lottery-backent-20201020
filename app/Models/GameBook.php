<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GameBook extends Model
{
    protected $table='booking_history';
    protected $fillable=['name','user_id','game_id','game_timing','bid_digit','close_date','bid_qty'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

}
