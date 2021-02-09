<?php

namespace App\Jobs;

use App\Models\Commission;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateCommissionBalanceCancel implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $user, $bid_qty;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$bid_qty)
    {
        $this->user = $user;
        $this->bid_qty = $bid_qty;
    }

    /**
     * Execute the job.
     *
     * @return void
     */

    public function handle()
    {


        $user = $this->user;
        $parent=$user->agent;
        // get user bookings on game

        $digit_wise_bids = 0;

        foreach ($this->bid_qty as $bid) {

            $digit_wise_bids = $digit_wise_bids + $bid;
            //total bid calculation
        }


        $amount=0;

        while ($parent && !$parent->hasRole('admin')) {

            $commissionbalance = Commission::where('user_id', $parent->id)
                ->first();

            if (!$commissionbalance) {
               /* $commissionbalance = Commission::create([
                    'user_id' => $parent->id,
                    'total_commission' => round($digit_wise_bids *($user->rate - $parent->rate) , 2)+$amount,
                ]);
                $amount=$amount+round($digit_wise_bids *($user->rate - $parent->rate) , 2);*/
            }else{
             //   $commissionbalance->total_commission = $commissionbalance->total_commission - round($digit_wise_bids *($user->rate - $parent->rate) , 2)-$amount;
                $commissionbalance->total_commission = $commissionbalance->total_commission - number_format($digit_wise_bids *($user->rate - $parent->rate), 2, '.', '')-$amount;
                $commissionbalance->save();

             //   $amount=$amount+round($digit_wise_bids *($user->rate - $parent->rate) , 2);
                $amount=$amount+number_format($digit_wise_bids *($user->rate - $parent->rate), 2, '.', '');
            }

            $user=$parent;
            $parent = $parent->agent;
        }

    }
}
