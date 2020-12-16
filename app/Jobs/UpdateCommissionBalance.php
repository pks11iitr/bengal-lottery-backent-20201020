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
 public $user,$amount;
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

        $commissionamount = $this->amount;

        if ($commissionamount > 0) {
            while ($user && !$user->hasRole('admin')) {

                $commissionbalance = Balance::where('user_id', $user->id)
                    ->first();

                if (!$commissionbalance) {
                    /* $stat = Balance::create([
                         'user_id' => $user->id,
                         'amount' => round($digit_wise_bids * $user->rate, 2),

                     ]);*/
                } else {
                    $commissionbalance->amount = $commissionbalance->amount + $commissionamount;
                    $commissionbalance->save();
                }

                $user = $user->agent;
            }

        }
    }
}
