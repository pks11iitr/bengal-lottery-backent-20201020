<?php

namespace App\Jobs;

use App\Models\Balance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateCommissionBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;

        $commissionbalance = Balance::where('user_id', $user->id)
            ->first();
        // get user bookings on game

        while ($user) {
            $digit_wise_bids = 0;

            foreach ($this->bid_qty as $bid) {

                $digit_wise_bids = $digit_wise_bids + $bid;
            }
            if (!$commissionbalance) {
                $stat = Balance::create([
                    'user_id' => $user->id,
                    'amount' => round($digit_wise_bids * $user->rate, 2),

                ]);
            }else{
                $commissionbalance->amount = $commissionbalance->amount - round($digit_wise_bids * $user->rate, 2);
            }

            $user = $user->agent;
        }

    }
}
