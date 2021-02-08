<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BidComment extends Model
{
    protected $table='bidcomment';

    protected $fillable=['user_id', 'game_id','comment'];
    protected $hidden = ['created_at','deleted_at','updated_at'];

}
