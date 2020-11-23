<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\GameBook;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function userslist(Request $request)
    {
        $user = Auth::user();

        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id','DESC')->get();
        foreach ($agents as $agent){
            $agent->balance=Transaction::balance($agent->id);
           // var_dump($agents['balance']);die();
            $agent->totaldeposit=Transaction::totaldeposit($agent->id);
            $agent->totalwithdraw=Transaction::totalwithdraw($agent->id);
        }
        //var_dump($balance);die();
        return view('portal.agent.add', compact('agents'));
    }



    public function createagent(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, array(
            "password" => "required|same:password",
            "cpassword" => "required|same:cpassword",
        ));
        $checkusername = User::where('email', strtoupper($request->username))->get();
   ///var_dump($request->status);die();
            if ($request->password == $request->cpassword) {
                if ($user->rate <= $request->rate) {

                $user = User::create([
                    'email' => strtoupper($request->username),
                    'password' => Hash::make($request->password),
                    'parent_id' => $user->id,
                    'status' => $request->status,
                    'rate' => $request->rate,
                    'account' => 'SUPER'
                ]);
                $user->assignRole('subadmin');
            }else{
                    return redirect()->back()->with('error', 'Game Rate Not Less Then Our Rate');
            }
            } else {
                return redirect()->back()->with('error', 'Password Does Not Match');
            }

        return redirect()->route("agents")->with('success', 'Agent Created Successfully');
    }

    public function agentdetails(Request $request)
    {
        $this->validate($request, array(
            "id" => "required",
        ));
        $returnData = array();
        $userid = $request->id;
        $users = User::where('id', $userid)->first();
        $detailsuser = json_decode(json_encode($users));
        return Response::json(["returnData" => $detailsuser]);
    }

    public function updateagent(Request $request)
    {

        $this->validate($request, array(
            "agent_id" => "required",

        ));
           $user = Auth::user();
           $balance=Transaction::balance($user->id);
        if(auth()->user()->hasRole('admin')){

                $agentdetails = User::where("id", $request->agent_id)->first();
                $agentdetails->deposit = $request->deposit_edit;
                $agentdetails->withdraw = $request->withdraw_edit;
                $agentdetails->status = $request->status_edit;
                $agentdetails->rate = $request->rate_edit;
                $agentdetails->save();
                if ($request->deposit_edit >= 0) {
                    $deposit = Transaction::create([
                        'user_id' => $request->agent_id,
                        'amount' => $request->deposit_edit,
                        'type' => 'Deposit',
                        'mode' => 'agent',
                    ]);
                }
                if ($request->withdraw_edit >= 0) {

                    $withdraw = Transaction::create([
                        'user_id' => $request->agent_id,
                        'amount' => $request->withdraw_edit,
                        'type' => 'Withdraw',
                        'mode' => 'agent',
                    ]);
                }

        }else{
            if($balance>=$request->deposit_edit) {
                if ($user->rate <= $request->rate_edit) {
                    $agentdetails = User::where("id", $request->agent_id)->first();
                    $agentdetails->deposit = $request->deposit_edit;
                    $agentdetails->withdraw = $request->withdraw_edit;
                    $agentdetails->status = $request->status_edit;
                    $agentdetails->rate = $request->rate_edit;
                    $agentdetails->save();
                    if ($request->deposit_edit >= 0) {
                        $deposit = Transaction::create([
                            'user_id' => $request->agent_id,
                            'amount' => $request->deposit_edit,
                            'type' => 'Deposit',
                            'mode' => 'agent',
                        ]);
                        $deposit = Transaction::create([
                            'user_id' => $user->id,
                            'amount' => $request->deposit_edit,
                            'type' => 'Deposit',
                            'mode' => 'subagent',
                        ]);
                    }
                    if ($request->withdraw_edit >= 0) {

                        $withdraw = Transaction::create([
                            'user_id' => $request->agent_id,
                            'amount' => $request->withdraw_edit,
                            'type' => 'Withdraw',
                            'mode' => 'agent',
                        ]);

                        $withdraw1 = Transaction::create([
                            'user_id' => $user->id,
                            'amount' => $request->withdraw_edit,
                            'type' => 'Withdraw',
                            'mode' => 'subagent',
                        ]);
                    }
                }else{
                    return redirect()->back()->with('error', 'Game Rate Not Less Then Our Rate');
                }
            }else{
                return redirect()->back()->with('error', 'Check Your balance Amount');
            }
        }

        return redirect()->route("agents");

    }

    public function index(Request $request,$id)
    {
        $gamebook = GameBook::where('user_id', $id)->get();
        return view('portal.agent.view', compact('gamebook'));
    }

    public function bookhistoryedit(Request $request,$id)
    {
        $game = Game::find($id);
        return view('portal.agent.edit',compact('game'));
    }

    public function bookhistoryupdate(Request $request,$id)
    {

        $this->validate($request, array(
            "bid_digit" => "required",
            "winning_amount" => "required",

        ));

        $game = Game::find($id);

        $values=GameBook::where('game_id',$id)->get();
        foreach ($values as $v){
            if($v->bid_digit==$request->bid_digit){

                $win = GameBook::where('id', $v->id)->update(['draw_result'=>(int)$request->bid_digit,'winning_amount'=>$request->winning_amount,'status'=>'Won']);
                  // var_dump($v->id);die();
                $order=Order::where('game_id',$id)->update(['draw_result'=>(int)$request->bid_digit]);


                $withdraw=Transaction::create([
                    'user_id' => $v->user_id,
                    'amount' => $v->bid_qty*$request->winning_amount,
                    'type' => 'Deposit',
                    'mode' => 'Winner',
                ]);

            }else{
                $win = GameBook::where('id', $v->id)->update(['draw_result'=>$request->bid_digit,'winning_amount'=>0,'status'=>'Loss']);

            }
        }

        return redirect()->route('gamelist');

    }

}
