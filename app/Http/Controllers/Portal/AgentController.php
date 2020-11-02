<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
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

        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->get();
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
                $user=User::create([
                    'email' => strtoupper($request->username),
                    'password' => Hash::make($request->password),
                    'parent_id' => $user->id,
                    'status' => $request->status,
                    'account' => 'SUPER'
                ]);
                $user->assignRole('subadmin');

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
        $agentdetails = User::where("id", $request->agent_id)->first();
        $agentdetails->deposit = $request->deposit_edit;
        $agentdetails->withdraw = $request->withdraw_edit;
        $agentdetails->status = $request->status_edit;
        $agentdetails->save();
        if((int)$request->deposit_edit>=0){
            $deposit=Transaction::create([
                'user_id' => $request->agent_id,
                'amount' => $request->deposit_edit,
                'type' => 'Deposit',
            ]);
        }
        if((int)$request->withdraw_edit>=0){

            $withdraw=Transaction::create([
                'user_id' => $request->agent_id,
                'amount' => $request->withdraw_edit,
                'type' => 'Withdraw',
            ]);
        }

        return redirect()->route("agents");

    }

}
