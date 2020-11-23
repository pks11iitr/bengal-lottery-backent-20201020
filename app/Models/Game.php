<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class Game extends Model
{
    protected $table='game';
    protected $fillable=['name','game_time','degit','close_date','isactive','price'];

    protected $hidden = ['created_at','deleted_at','updated_at'];
    public function getCloseDateAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('d M Y');
    }
  protected $appends=['orginal','time'];
    public function getGameTimeAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('h:i A');
    }
    public function getorginalAttribute($value){
        return \Carbon\Carbon::parse($this->close_date)->format('Y-m-d');
    }
    public function getTimeAttribute($value){
        return \Carbon\Carbon::parse($this->game_time)->format('H:i');
    }

//    public function getRemainingAttribute($value){
//
//      $date=  \Carbon\Carbon::parse($this->close_date)->format('Y-m-d');
//      $time=  \Carbon\Carbon::parse($this->game_time)->format('H:i');
//      $datetime=$date." ".$time;
//     // var_dump($datetime);
//      $enddate=strtotime($datetime);
//      $newdate=date('Y-m-d H:i');
//     // var_dump($newdate);die();
//      $current=strtotime($newdate);
//      $remaining=$enddate-$current;
//        return $remaining;
//    }


}
