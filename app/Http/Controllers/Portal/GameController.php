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
        ));

        Game::create([
            'name' => $request->name,
            'game_time' => $request->game_time,
            'degit' => $request->degit,
        ]);
        return redirect()->route("gamelist")->with('success', 'Game Created Successfully');
    }

    public function editgame(Request $request,$id)
    {
        $games = Game::find($id);
        return view('portal.game.edit',compact('games'));
    }

    public function updategame(Request $request,$id)
    {

        $this->validate($request, array(
            "name" => "required",

        ));

        $game = Game::find($id);
        $game->name = $request->name;
        $game->game_time = $request->game_time;
        $game->degit = $request->degit;
        $game->save();

        return redirect()->route("gamelist");

    }

}
