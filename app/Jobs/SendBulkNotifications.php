<?php

namespace App\Jobs;

use App\Models\Customer;
use App\Models\Notification;
use App\Models\Order;
use App\Services\Notification\FCMNotification;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendBulkNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $title, $message, $stores;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($title, $message, $stores)
    {
        $this->title=$title;
        $this->message=$message;
        $this->stores=$stores;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //var_dump($this->stores);die;
//        $user_ids=Order::whereIn('store_id', $this->stores)->select('user_id')->get();
//
//        $user_ids=$user_ids->map(function($id){
//            return $id->user_id;
//        });
//
//        if(!empty($user_ids)){
//            $tokens=User::whereIn('id', $user_ids)
//                ->where('token', '!=', null)
//                ->select('token')
//                ->get();
//        }else{
            $tokens=User::
                where('token', '!=', null)
                ->select('token')
                ->get();
       // }


        Notification::create([
            'user_id'=>0,
            'title'=>$this->title,
            'description'=>$this->message,
            'data'=>null,
            'type'=>'all'
        ]);

        foreach($tokens as $token){

            FCMNotification::sendNotification($token, $this->title??'', $this->message??'alam');

        }


    }
}
