<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    protected $table='game';
    protected $fillable=['name','game_time','degit','close_date','isactive','bid_qty'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

}
