<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\Marketer;
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
            "isactive" => "required",
        ));

        Game::create([
            'name' => $request->name,
            'game_time' => $request->game_time,
            'close_date' => $request->close_date,
            'price' => $request->price,
            'isactive' => $request->isactive,
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
            "isactive" => "required",

        ));

        $game = Game::find($id);
        $game->name = $request->name;
        $game->game_time = $request->game_time;
        $game->close_date = $request->close_date;
        $game->price = $request->price;
        $game->isactive = $request->isactive;
        $game->save();

        return redirect()->route("gamelist");

    }

}
