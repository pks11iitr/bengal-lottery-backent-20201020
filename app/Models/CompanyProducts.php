<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use DB;

class CompanyProducts extends Model {
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $connection = 'mysql';
    protected $table = 'company_products';
    public $timestamps = true;
    public $appends=['caution_image'];

    protected $fillable=['name', 'license', 'sku', 'sku_size', 'image', 'antidote_statement', 'caution_id','user_id', 'brand_name'];


    public function getImageAttribute($value){
        if($value)
            return Storage::url($value);
        return null;
    }

    public function getCautionImageAttribute(){
        return '/caution-images/'.$this->caution_id.'.png';
    }
}
