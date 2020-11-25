<?php

namespace App\Http\Controllers\Portal;

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

    public function createsave(Request $request)
    {
        $this->validate($request, array(
            "title" => "required",
            "message" => "required",

        ));

        $notification=   Notification::create([
            'title' => $request->title,
            'message' => $request->message,
        ]);


        return redirect()->back()->with('success', 'Send Notification Successfully');
    }



}
