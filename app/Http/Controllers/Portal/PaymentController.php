<?php

namespace App\Http\Controllers\Portal;

use App\Models\Configuration;
use App\Models\Payment;
use App\Models\Plans;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function plans(Request $request){

        return view('portal.payment-plans');

    }

    public function subscribe(Request $request, $id){

        return redirect()->route('dashboard')->with('error', 'Online Payments are not active this time. Please contact support to subscribe this service');

        $plan=Plans::where('is_trial', false)->findOrFail($id);

        $api_key=$this->payment->api_key;
        $user=auth()->user();

        $refid=date('YmdHis');
        $response=$this->payment->generateorderid([
            "amount"=>$plan->price*100,
            "currency"=>"INR",
            "receipt"=>$refid,
        ]);
        $responsearr=json_decode($response);
        if(isset($responsearr->id)){
            $payment=Payment::create([
                'refid'=>$refid,
                'user_id'=>$user->id,
                'amount'=>$plan->price,
                'razorpay_order_id'=>$responsearr->id,
                'order_id_response'=>$response
            ]);

            return view('portal.checkout', compact('payment','api_key', 'plan'));

        }else{
            return redirect()->back()->with('error', 'Payment cannot be initiated');
        }


    }
}
