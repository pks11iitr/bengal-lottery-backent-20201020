<?php

namespace App\Http\Controllers\Portal;

use App\Http\Controllers\Controller;
use App\Jobs\SendBulkNotifications;
use App\Models\Notification;
use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    public function create(Request $request){
        $stores=User::where('id', '>', 1)->select('email', 'id')->get();
        return view('portal.notification.add', compact('stores'));
    }

    public function createsave(Request $request){
        $request->validate([
            'title'=>'required',
            'description'=>'required'
        ]);

        if($notification=Notification::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'type'=>'all',
            'user_id'=>'0',

        ]))
        {
            dispatch(new SendBulkNotifications($request->title,$request->description, $request->store_ids));
            return redirect()->back()->with('success', 'Notification Send Successfully');
        }
        return redirect()->back()->with('error', 'Notification failed');
    }

}
