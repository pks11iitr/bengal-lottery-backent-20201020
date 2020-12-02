<?php

namespace App\Http\Controllers\Portal\Api;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NotificationController extends Controller
{
    public function index(Request $request){

        $user=auth()->guard('api')->user();
        if(!$user){
            $notifications=Notification::where('type', 'all')->select('title', 'description', 'created_at')->orderBy('created_at', 'desc')->get();

        }else{
            $notifications=Notification::where('user_id', $user->id)->orWhere('type', 'all')->select('title', 'description', 'created_at')->orderBy('created_at', 'desc')->get();
        }

        return [
            'status'=>'success',
            'data'=>compact('notifications')
        ];



    }
}
