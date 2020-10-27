<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class MappedCode extends Model
{
    use SoftDeletes;

    protected $table='mapped_codes';

    protected $fillable=['product_id', 'manufacturer_id','mapped_id', 'prefix', 'sequence_start', 'sequence_end', 'total', 'batch_number', 'manufactured_date', 'expiry_date','can_be_unmapped', 'file_path', 'user_id','marketer_id'];

    public function product(){
        return $this->belongsTo('App\Models\CompanyProducts', 'product_id');
    }

    public function manufacturer(){
        return $this->belongsTo('App\Models\Manufacturers', 'manufacturer_id');
    }

    public function marketer(){
        return $this->belongsTo('App\Models\Marketer', 'marketer_id');
    }

    public function getFilePathAttribute($value){

        if($value)
            return Storage::disk('s3')->url($value);
        return null;

    }

    public function printFormat($sequence){

        $len=strlen($sequence);
        //$sequence=$this->sequence_start;
        for($i=0;$i<11-$len;$i++){
            $sequence='0'.$sequence;
        }
        return $this->prefix.$sequence;

    }

}
