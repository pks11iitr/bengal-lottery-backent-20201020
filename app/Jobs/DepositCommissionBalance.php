<?php

namespace App\Jobs;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DepositCommissionBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public  $user, $amount;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$amount)
    {
        $this->user = $user;
        $this->amount = $amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        //$parent=$user->agent;
        // get user bookings on game

        $commission_amount=$this->amount;

        if($commission_amount>0){
            while ($user && !$user->hasRole('admin')) {

                $commission = Commission::where('user_id', $user->id)
                    ->first();

                if (!$commission) {
                    /* $stat = Balance::create([
                         'user_id' => $user->id,
                         'amount' => round($digit_wise_bids * $user->rate, 2),

                     ]);*/
                }else{
                    $commission->total_commission = $commission->total_commission - $commission_amount;
                    $commission->save();
                }

              //  $user=$parent;
                $user = $user->agent;
            }
        }
    }
}
