<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\GamePrice;
use App\Models\GameBook;
use App\Models\Marketer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class GameController extends Controller
{
    public function index(Request $request)
    {
        $games = Game::get();

        return view('portal.game.view', compact('games'));
    }

    public function create(Request $request)
    {
        return view('portal.game.add');
    }

    public function gamesave(Request $request)
    {
        $this->validate($request, array(
            "name" => "required",
            "game_time" => "required",
            "close_date" => "required",
            "price" => "required",
            "degit" => "required",
            "isactive" => "required",
        ));
        $user=auth()->user();
     $game=   Game::create([
            'name' => $request->name,
            'game_time' => $request->game_time,
            'close_date' => $request->close_date,
            'price' => $request->price,
            'degit' => $request->degit,
            'isactive' => $request->isactive,
        ]);
        GamePrice::create([
            'agent_id' => $user->id,
            'game_id' => $game->id,
            'game_price' => $request->price,

        ]);

        return redirect()->route("gamelist")->with('success', 'Game Created Successfully');
    }

    public function editgame(Request $request,$id)
    {
        $game = Game::find($id);
        return view('portal.game.edit',compact('game'));
    }

    public function updategame(Request $request,$id)
    {

        $this->validate($request, array(
            "name" => "required",
            "game_time" => "required",
            "close_date" => "required",
            "price" => "required",
            "degit" => "required",
            "isactive" => "required",

        ));

        $game = Game::find($id);
        $game->name = $request->name;
        $game->game_time = $request->game_time;
        $game->close_date = $request->close_date;
        $game->price = $request->price;
        $game->degit = $request->degit;
        $game->isactive = $request->isactive;
        $game->save();

        return redirect()->route("gamelist");

    }

    public function gametotal(Request $request,$id)
    {
        $zerocount=0;$firstcount=0;$secondcount=0;$thirdcount=0;$fourthcount=0;
        $fifthcount=0;$sixthcount=0;$seventhcount=0;$eightcount=0;$ningthcount=0;
        $gamebook = GameBook::where('game_id',$id)->get();
        foreach ($gamebook as $gbook){
            if($gbook->bid_digit==0){
                $zerocount=$zerocount+1;
            }elseif($gbook->bid_digit==1){
                $firstcount=$firstcount+1;
            }elseif($gbook->bid_digit==2){
                $secondcount=$secondcount+1;
            }elseif($gbook->bid_digit==3){
                $thirdcount=$thirdcount+1;
            }elseif($gbook->bid_digit==4){
                $fourthcount=$fourthcount+1;
            }elseif($gbook->bid_digit==5){
                $fifthcount=$fifthcount+1;
            }elseif($gbook->bid_digit==6){
                $sixthcount=$sixthcount+1;
            }elseif($gbook->bid_digit==7){
                $seventhcount=$seventhcount+1;
            }elseif($gbook->bid_digit==8){
                $eightcount=$eightcount+1;
            }elseif($gbook->bid_digit==9){
                $ningthcount=$ningthcount+1;
            }
        }
        return view('portal.game.booking_list',compact('zerocount','firstcount','secondcount','thirdcount','fourthcount','fifthcount','sixthcount','seventhcount','eightcount','ningthcount'));
    }

}
