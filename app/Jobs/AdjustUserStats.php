<?php

namespace App\Jobs;

use App\Models\UserStat;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class AdjustUserStats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user,$game,$tickets;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user,$game,$tickets)
    {
        $this->user=$user;
        $this->game=$game;
        $this->tickets=$tickets;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user=$this->user;

        do{

            $stat=UserStat::where('game_id', $this->game->id)
                ->where('user_id', $this->user->id)
                ->first();
            if(!$stat)
                $stat=UserStat::create([
                    'user_id'=>$this->user->id,
                    'game_id'=>$this->game->id,
                    'digit0'=>0,
                    'digit1'=>0,
                    'digit2'=>0,
                    'digit3'=>0,
                    'digit4'=>0,
                    'digit5'=>0,
                    'digit6'=>0,
                    'digit7'=>0,
                    'digit8'=>0,
                    'digit9'=>0,
                ]);

            $stat->digit0=$stat->digit0+$this->tickets[0];
            $stat->digit1=$stat->digit1+$this->tickets[1];
            $stat->digit2=$stat->digit2+$this->tickets[2];
            $stat->digit3=$stat->digit3+$this->tickets[3];
            $stat->digit4=$stat->digit4+$this->tickets[4];
            $stat->digit5=$stat->digit5+$this->tickets[5];
            $stat->digit6=$stat->digit6+$this->tickets[6];
            $stat->digit7=$stat->digit7+$this->tickets[7];
            $stat->digit8=$stat->digit8+$this->tickets[8];
            $stat->digit9=$stat->digit9+$this->tickets[9];
            $stat->save();

            $user=$user->agent;

        }while($user!=null);
    }
}
