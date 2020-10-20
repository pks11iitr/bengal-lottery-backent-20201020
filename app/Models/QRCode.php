<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class QRCode extends Model
{
    protected $table ='qr_codes';

    protected $fillable=['user_id', 'refid', 'sequence_prefix', 'sequence_start', 'sequence_end', 'total', 'remaining', 'file_path', 'is_expired', 'marketer_id'];


    public static function availableSequences(){

        $codes=QRCode::where('is_expired', false)
            ->select('id', 'sequence_start', 'sequence_end')
            ->orderBy('sequence_start', 'asc')
            ->get();

        $mapped=MappedCode::where('can_be_unmapped', true)
            ->select('id', 'sequence_start', 'sequence_end')
            ->orderBy('sequence_start', 'asc')
            ->get();

        $availableslots=[];
        foreach($codes as $c){
            $start=$c->sequence_start;
            foreach($mapped as $m){
                if($start < $m->sequence_start)
                    $availableslots=['id'=>$c->id, 'start'=>$start, 'end'=>$m->sequence_start-1];
                    $start=$m->sequence_end+1;
            }
            if($start < $c->sequence_end){
                $availableslots=['id'=>$c->id, 'start'=>$start, 'end'=>$m->sequence_end];
                $start=$c->sequence_end+1;
            }
        }

        return $availableslots;

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
        return $this->sequence_prefix.$sequence;

    }

}
