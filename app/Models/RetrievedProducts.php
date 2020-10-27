<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use DB;

class RetrievedProducts extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $connection = 'mysql';
    protected $table = 'retrieved_products';
    public $timestamps = true;

    protected $fillable=['user_id', 'product_name', 'license'];
}
