<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table='notifications';

    protected $hidden = ['deleted_at','updated_at'];

    protected $fillable=['user_id', 'title', 'description', 'data', 'type'];


}
