<?php

namespace App\Jobs;

use App\Models\Balance;
use App\Models\GameBook;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateBookingBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user, $bid_qty;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $bid_qty)
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

        // get user bookings on game

        $digit_wise_bids = 0;

        foreach ($this->bid_qty as $bid) {

            $digit_wise_bids = $digit_wise_bids + $bid;
        }

      //  $booking_balance=round($digit_wise_bids * $user->rate, 2);
        $booking_balance=number_format(($digit_wise_bids * $user->rate), 2, '.', '');

        if($booking_balance>0){
            while ($user && !$user->hasRole('admin')) {

                $bookingbalance = Balance::where('user_id', $user->id)
                    ->first();

                if (!$bookingbalance) {
                    /* $stat = Balance::create([
                         'user_id' => $user->id,
                         'amount' => round($digit_wise_bids * $user->rate, 2),

                     ]);*/
                }else{
                    $bookingbalance->amount = $bookingbalance->amount - $booking_balance;
                    $bookingbalance->save();
                }

                $user = $user->agent;
            }
        }
    }
}
