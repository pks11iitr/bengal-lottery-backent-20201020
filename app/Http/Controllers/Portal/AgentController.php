<?php

namespace App\Http\Controllers\Portal;

use App\Jobs\UpdateCommissionBalance;
use App\Jobs\UpdateWinBalances;
use App\Models\Balance;
use App\Models\CompanyProducts;
use App\Models\Game;
use App\Models\GameBook;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\UserStat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use App\Jobs\ActiveInactiveUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    public function userslist(Request $request)
    {
        $user = Auth::user();

        $agents = User::where('parent_id', $user->id)->whereNotNull('parent_id')->orderBy('id','DESC')->get();
        $total=0;
        foreach ($agents as $agent){
            $balance=Transaction::balance($agent->id);
            $agent->balance=round($balance,2);
            // var_dump($agents['balance']);die();
            $totaldeposit=Transaction::totaldeposit($agent->id);
             $agent->totaldeposit=round($totaldeposit,2);
            $totalwithdraw=Transaction::totalwithdraw($agent->id);
            $agent->totalwithdraw=round($totalwithdraw,2);

            //commission

            $totalcommission=Transaction::totalcommission($agent->id);
            $agent->totalcommission=round($totalcommission,2);
            $totalprofitcommission=Transaction::totalprofitcommition($agent->id,$agent->rate, $user->rate);
            $agent->totalprofitcommission=round($totalprofitcommission,2);
            $agent->avl_balance=Balance::avl_balance($agent->id);
           //end commission
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
            if(auth()->user()->hasRole('admin')){
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

                //  var_dump($user->rate );
                //  var_dump($request->rate);
                //  die;

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
        $agentbalance=Transaction::balance($request->agent_id);
        if(auth()->user()->hasRole('admin')){

            $agentdetails = User::where("id", $request->agent_id)->first();
            $agentdetails->deposit = $request->deposit_edit;
            $agentdetails->withdraw = $request->withdraw_edit;
            //var_dump($request->status_edit);die();
            if($request->status_edit==0){

                $agentdetails->status = 0;
                dispatch(new ActiveInactiveUser($agentdetails, 0));
            }elseif($request->status_edit==1){
                $agentdetails->status = $request->status_edit;
                dispatch(new ActiveInactiveUser($agentdetails, $request->status_edit));
            }elseif($request->status_edit==2){
                $agentdetails->status = $request->status_edit;
                dispatch(new ActiveInactiveUser($agentdetails, $request->status_edit));
            }

            $agentdetails->rate = $request->rate_edit;
            $agentdetails->save();

            if ($request->deposit_edit > 0) {

                $deposit = Transaction::create([
                  //  'user_id' => $request->agent_id,
                    'to_user_id' => $user->id,
                    'user_id' => $request->agent_id,
                    'amount' => $request->deposit_edit,
                    'avl_balance' => round($agentbalance,2)+$request->deposit_edit,
                    'type' => 'Deposit',
                    'mode' => 'agent',
                ]);

                $deposit = Transaction::create([
                    //  'user_id' => $request->agent_id,
                    'user_id' => $user->id,
                    'to_user_id' => $request->agent_id,
                    'amount' => $request->deposit_edit,
                    'avl_balance' => round($balance,2)-$request->deposit_edit,
                    'type' => 'Withdraw',
                    'mode' => 'agent',
                ]);
                $balance=Balance::update_deposit_balance($user->id,$request->agent_id,$request->deposit_edit);

            }
            if ($request->withdraw_edit > 0) {

                $withdraw = Transaction::create([
                   // 'user_id' => $request->agent_id,
                    'user_id' => $request->agent_id,
                    'to_user_id' => $user->id,
                    'amount' => $request->withdraw_edit,
                    'avl_balance' => round($agentbalance,2)-$request->withdraw_edit,
                    'type' => 'Withdraw',
                    'mode' => 'agent',
                ]);
                $withdraw = Transaction::create([
                    // 'user_id' => $request->agent_id,
                    'to_user_id' => $request->agent_id,
                    'user_id' => $user->id,
                    'amount' => $request->withdraw_edit,
                    'avl_balance' => round($balance,2)+$request->withdraw_edit,
                    'type' => 'Deposit',
                    'mode' => 'agent',
                ]);

                $balance=Balance::update_withdraw_balance($request->agent_id,$user->id,$request->withdraw_edit);
            }

        }else{
            if($balance>=$request->deposit_edit) {
                if ($user->rate <= $request->rate_edit) {
                    $agentdetails = User::where("id", $request->agent_id)->first();
                    $agentdetails->deposit = $request->deposit_edit;
                    $agentdetails->withdraw = $request->withdraw_edit;
                  //  $agentdetails->status = $request->status_edit;
                    if($request->status_edit==0){

                        $agentdetails->status = 0;
                        dispatch(new ActiveInactiveUser($agentdetails, 0));
                    }elseif($request->status_edit==1){
                        $agentdetails->status = $request->status_edit;
                        dispatch(new ActiveInactiveUser($agentdetails, $request->status_edit));
                    }elseif($request->status_edit==2){
                        $agentdetails->status = $request->status_edit;
                        dispatch(new ActiveInactiveUser($agentdetails, $request->status_edit));
                    }
                    $agentdetails->rate = $request->rate_edit;
                    $agentdetails->save();
                    if ($request->deposit_edit >0) {
                        $deposit = Transaction::create([
                            'to_user_id' => $user->id,
                            'user_id' => $request->agent_id,
                            'amount' => $request->deposit_edit,
                            'avl_balance' => round($agentbalance,2)+$request->deposit_edit,
                            'type' => 'Deposit',
                            'mode' => 'agent',
                        ]);
//                        $deposit1 = Transaction::create([
//                            //  'user_id' => $request->agent_id,
//                            'user_id' => $user->id,
//                            'to_user_id' => $request->agent_id,
//                            'amount' => $request->deposit_edit,
//                            'type' => 'Deposit',
//                            'mode' => 'agent',
//                        ]);
                        $deposit2 = Transaction::create([
                            'user_id' => $user->id,
                            'to_user_id' => $request->agent_id,
                            'amount' => $request->deposit_edit,
                            'avl_balance' => round($balance,2)-$request->deposit_edit,
                            'type' => 'Withdraw',
                            'mode' => 'subagent',
                        ]);
//                        $deposit3 = Transaction::create([
//                            //'user_id' => $user->id,
//                            'to_user_id' => $request->agent_id,
//                            'user_id' => $user->id,
//                            'amount' => $request->deposit_edit,
//                            'type' => 'Withdraw',
//                            'mode' => 'subagent',
//                        ]);

                        $balance=Balance::update_deposit_balance($user->id,$request->agent_id,$request->deposit_edit);
                    }
                    if ($request->withdraw_edit > 0) {

                        $withdraw = Transaction::create([
                           /// 'user_id' => $request->agent_id,
                            'to_user_id' => $user->id,
                            'user_id' => $request->agent_id,
                            'amount' => $request->withdraw_edit,
                            'avl_balance' => round($agentbalance,2)-$request->withdraw_edit,
                            'type' => 'Withdraw',
                            'mode' => 'agent',
                        ]);

//                        $withdraw2 = Transaction::create([
//                            /// 'user_id' => $request->agent_id,
//                            'to_user_id' => $user->id,
//                            'user_id' => $request->agent_id,
//                            'amount' => $request->withdraw_edit,
//                            'type' => 'Withdraw',
//                            'mode' => 'agent',
//                        ]);
                        $withdraw1 = Transaction::create([
                            //'user_id' => $user->id,
                            'to_user_id' => $request->agent_id,
                            'user_id' => $user->id,
                            'amount' => $request->withdraw_edit,
                            'avl_balance' => round($balance,2)+$request->withdraw_edit,
                            'type' => 'Deposit',
                            'mode' => 'subagent',
                        ]);
//                        $withdraw3 = Transaction::create([
//                            //'user_id' => $user->id,
//                            'user_id' => $request->agent_id,
//                            'to_user_id' => $user->id,
//                            'amount' => $request->withdraw_edit,
//                            'type' => 'Deposit',
//                            'mode' => 'subagent',
//                        ]);
                        $balance=Balance::update_withdraw_balance($request->agent_id,$user->id,$request->withdraw_edit);
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


        $values=GameBook::where('game_id',$id)->get();
        $game = Game::find($id);
        $order=Order::where('game_id',$id)->update(['draw_result'=>(int)$request->bid_digit]);
        foreach ($values as $v){
            if($v->bid_digit==$request->bid_digit){

                $win = GameBook::where('id', $v->id)->update(['draw_result'=>(int)$request->bid_digit,'winning_amount'=>$request->winning_amount,'status'=>'Won']);
                // var_dump($v->id);die();
                $game->bid_qty=(int)$request->bid_digit;
                $game->isactive=2;
                $game->update();
                $balance=Transaction::balance($v->user_id);
                $withdraw=Transaction::create([
                    'user_id' => $v->user_id,
                    'to_user_id' => $v->user_id,
                    'amount' => round(($v->bid_qty*$request->winning_amount),2),
                    'avl_balance' => round($balance,2)+round(($v->bid_qty*$request->winning_amount),2),
                    'type' => 'win',
                    'mode' => 'Winner',
                ]);

            }else{
                $win = GameBook::where('id', $v->id)->update(['draw_result'=>$request->bid_digit,'winning_amount'=>0,'status'=>'Loss']);

            }

        }
        dispatch(new UpdateWinBalances($request->bid_digit, $id,$request->winning_amount))->onQueue('instant');

        return redirect()->route('gamelist');

    }

    public function paymenthistory(Request $request,$id)
    {
        $payments = Transaction::where('user_id', $id)->orderBy('id','DESC')->get();
        return view('portal.agent.paymenthistory', compact('payments'));
    }

    public function parent_history(Request $request)
    {
        $user = Auth::user();
        $payments = Transaction::where('user_id', $user->id)->orderBy('id','DESC')->get();
        return view('portal.agent.paymenthistory', compact('payments'));
    }

//startcommission
    public function commissioncreate(Request $request,$id)
    {
        return view('portal.agent.commission',['id'=>$id]);
    }

    public function commissionsave(Request $request)
    {
        $this->validate($request, array(
            "commission" => "required|min:1",
            "agent_id" => "required",
        ));

        $user=auth()->user();
        $agent=User::find($request->agent_id);
        $totalcommission=Transaction::totalcommission($agent->id);
        //$totalcommission=round($totalcommission,2);
        $totalprofitcommission=Transaction::totalprofitcommition($agent->id,$agent->rate,$user->rate);
       // $totalprofitcommission=round($totalprofitcommission,2);
        $balancecommission=round(($totalprofitcommission-$totalcommission),2);
        if($balancecommission < $request->commission)
        {

            return redirect()->back()->with('error', 'You dont have sufficient Commission to be Deposit');
        }
        $balance=Transaction::balance($user->id);
        $agentbalance=Transaction::balance($request->agent_id);
            $commissionDeposit=Transaction::create([
                'to_user_id' => $request->agent_id,
                'user_id' => $user->id,
                'amount' => $request->commission,
                'avl_balance' => round($balance,2)+$request->commission,
                'type' => 'Deposit',
                'mode' => 'commission',
            ]);

            $commission=Transaction::create([
                'user_id' => $request->agent_id,
                'to_user_id' => $user->id,
                'amount' => $request->commission,
                'avl_balance' => round($agentbalance,2),
                'type' => 'commission',
                'mode' => 'commission',
            ]);

       // $commission_balance=Transaction::commission_balance($user->id,$request->agent_id,$request->commission);
        dispatch(new UpdateCommissionBalance($user,$request->commission))->onQueue('instant');

        return redirect()->route('agents')->with('success', 'Commission Deposit Successfully');
    }

}
