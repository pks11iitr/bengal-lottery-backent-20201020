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

    public function getGameTimeAttribute($value) {
        return \Carbon\Carbon::parse($value)->format('h:i A');
    }
}
