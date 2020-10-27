<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;

class Manufacturers extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $connection = 'mysql';
    protected $table = 'manufacturers';
    public $timestamps = false;

    protected $fillable=['user_id','m_name','m_alias','m_license','state_id','city_name','m_address','m_pincode','state_name','phone_no'];
}
