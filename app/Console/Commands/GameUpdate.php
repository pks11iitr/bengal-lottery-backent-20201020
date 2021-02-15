<?php

namespace App\Console\Commands;

use App\Models\Game;
use Illuminate\Console\Command;

class GameUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $games = Game::where('isactive', 1)->get();

        if ($games->count() > 0) {

            foreach ($games as $a)

            $closedate = $a->close_date;
            $closetime = $a->game_time;
            $closedatetime = $closedate . " " . $closetime;
            $closedatevalue = strtotime($closedatetime);

            $currentdate = date('Y-m-d H:i:s');
            $currentvalue = strtotime($currentdate);

            if ($currentvalue >= $closedatevalue) {

                $game = Game::find($a->id);
                $game->isactive = 3;
                $game->save();
            }
            /*$this->info('Hourly Update has been send successfully');*/
        }
    }
}
