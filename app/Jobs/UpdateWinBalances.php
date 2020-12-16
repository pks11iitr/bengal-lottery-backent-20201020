<?php

namespace App\Jobs;

use App\Models\Game;
use App\Models\GameBook;
use App\User;
use App\Models\Balance;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateWinBalances implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $winning_digit, $game_id, $amount;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($winning_digit, $game_id, $amount)
    {
        $this->winning_digit=$winning_digit;
        $this->game_id=$game_id;
        $this->amount=$amount;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $game=Game::findOrFail($this->game_id);
        $offset=0;
        do{

            $user_main_iterator=User::whereHas('orders', function($orders) use($game){
                $orders->where('game_id', $game->id);
            })
            ->skip($offset)
                ->take(1)
                ->first();

            if($user_main_iterator) {

                // get user bookings on game
                $digit_wise_bids=[];

                $users_bids=GameBook::where('game_id', $this->game_id)
                    ->where('user_id', $user_main_iterator->id)
                    ->get();

                foreach($users_bids as $bid){
                    if(!isset($digit_wise_bids[$bid->bid_digit])){
                        $digit_wise_bids[$bid->bid_digit]=0;
                    }
                    $digit_wise_bids[$bid->bid_digit]=$digit_wise_bids[$bid->bid_digit]+$bid->bid_qty;
                }

                //winning_balance
                $winning_balance=(($digit_wise_bids[$this->winning_digit]??0)*$this->amount)??0;



                //update balances if winbalance is greater than 0
                if($winning_balance>0){

                    $user_parent_iterator = $user_main_iterator;
                    while ($user_parent_iterator && !$user_parent_iterator->hasRole('admin')) {

                        //update user balance
                        $balance=Balance::where('user_id', $user_parent_iterator->id)->first();
                        if($balance){
                            $balance->amount=$balance->amount+$winning_balance;
                            $balance->save();
                        }else{
                            Balance::create([
                                'user_id'=>$user_parent_iterator->id,
                                'amount'=>$winning_balance,
                            ]);
                        }

                        $user_parent_iterator=$user_parent_iterator->agent;

                    }
                }

            }

            $offset++;

        }while($user_main_iterator);
    }
}
