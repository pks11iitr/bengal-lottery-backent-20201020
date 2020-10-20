<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;

class QrCodes extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $connection = 'mysql';
    protected $table = 'qr_codes';
    public $timestamps = true;
}
