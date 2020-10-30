<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Transaction extends Model
{
    protected $table='transactions';
    protected $fillable=['user_id','type','amount'];

    protected $hidden = ['created_at','deleted_at','updated_at'];

}
