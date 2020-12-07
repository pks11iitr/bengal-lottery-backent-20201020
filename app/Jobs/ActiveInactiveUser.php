<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ActiveInactiveUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $status)
    {
        $this->user=$user;
        $this->status=$status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=$this->user;
        if($user){
            $user->status=$this->status;
            $user->save();
            $this->changeChildsStatus($user, $this->status);
        }

    }

    private function changeChildsStatus($user, $status){
        if($user){
            foreach($user->childs as $c){
                $c->status=$status;
                $c->save();
                $this->changeChildsStatus($c, $status);
            }
        }
    }

}
