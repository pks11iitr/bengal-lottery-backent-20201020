<?php

namespace App\Http\Controllers\Portal;

use App\Jobs\SendBulkNotifications;
use App\Models\Notification;
use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Response;


class NotificationController extends Controller
{
//    public function index(Request $request)
//    {
//        return view('portal.notification.add');
//    }

    public function create(Request $request)
    {
        return view('portal.notification.add');
    }

    public function createsave(Request $request){
        $request->validate([
            'title'=>'required',
            'message'=>'required'
        ]);


        if($notification=Notification::create([
            'title'=>$request->title,
            'message'=>$request->message,
            'type'=>'all',
            'user_id'=>'0',

        ]))
        {
            FCMNotification::sendNotification($token, $request->title, $request->message);
            return redirect()->back()->with('success', 'Notification Send Successfully');
        }
        return redirect()->back()->with('error', 'Notification failed');
    }



}
