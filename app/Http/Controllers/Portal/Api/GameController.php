<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GameController extends Controller
{

    public function index(Request $request){
        $games=Game::where('isactive',1)->get();
        if($games->count()>0){
         return [
             'status'=>'success',
             'data'=>$games
             ];
           }else{
             return [
                  'status'=>'No Record Found',
                   'code'=>'402'
             ];
           }
    }


}
