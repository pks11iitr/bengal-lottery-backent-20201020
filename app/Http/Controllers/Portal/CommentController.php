<?php

namespace App\Http\Controllers\Portal;

use App\Models\BidComment;
use App\Models\Marketer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use App\Models\Manufacturers;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class CommentController extends Controller
{

    public function comment(Request $request){
        $user = Auth::user();
        $agents = User::where('parent_id',$user->id)->get();
        $commen=[];
        foreach ($agents as $agent){

            $comments=BidComment::where('user_id',$agent->id)->get();

            foreach ($comments as $comm){
                $commen[]=array(
                        'user_id'=>$comm->customer->email,
                        'game_id'=>$comm->gamename->name,
                        'comment'=>$comm->comment,
                        'created_at'=>$comm->created_at,
                );
            }
        }
       // return $commen;
        return view('portal.agent.bidcomment',compact('commen'));
    }

}
