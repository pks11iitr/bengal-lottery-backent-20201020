<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class GamePrice extends Model
{
    protected $table='game_price';
    protected $fillable=['agent_id','game_id','game_price'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

    public function game(){
        return $this->belongsTo('App\Models\Game', 'game_id');
    }
}
