<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Marketer extends Model
{
    protected $table='marketers';

    protected $fillable=['name', 'user_id'];
}
