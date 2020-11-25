<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserStat extends Model
{
    protected $table='user_stats';

    protected $fillable=['user_id', 'game_id', 'digit0','digit1','digit2','digit3','digit4','digit5','digit6','digit7','digit8','digit9'];
}
