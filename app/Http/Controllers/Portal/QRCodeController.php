<?php

namespace App\Http\Controllers\Portal;

use App\Models\CompanyProducts;
use App\Models\Manufacturers;
use App\Models\MappedCode;
use App\Models\Marketer;
use App\Models\QRCode;
use App\User;
use Aws\Lambda\Exception\LambdaException;
use Aws\Lambda\LambdaClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QRCodeController extends Controller
{
    public function index(Request $request){

        $user=auth()->user();
        $codes=QRCode::orderBy('id', 'desc')
            ->get();
        $products=CompanyProducts::where('user_id', $user->id)
            ->select('name', 'sku', 'sku_size', 'id')
            ->get();
        $manufacturers=Manufacturers::where('user_id', $user->id)
            ->select('m_name', 'id')
            ->get();
        $marketers=Marketer::where('user_id', $user->id)
            ->select('name', 'id')
            ->get();
        return view('portal.qrcodes', compact('codes', 'user','products', 'manufacturers', 'marketers'));

    }

    public function generatecode(Request $request){
        //return $request->all();

        $request->validate([
            'count'=>'required|integer|max:1000000'
        ]);

        $user=auth()->user();

        if($user->plan_expiry<date('Y-m-d')){
            return [
                'status'=>'failed',
                'message'=> 'Your Membership Plan Has Been Expired. Please Renew Your Plan To Use Services'
            ];
        }

        //if($user->qr)

        if($user->qr_balance<$request->count)
            return [
                'status'=>'failed',
                'message'=> 'Your Remaining QR Code Balance is '.$user->qr_balance.' only'
            ];

        $max=QRCode::where('user_id', $user->id)->max('sequence_end');
        if(!$max)
            $max=0;
        $max=$max+1;

        $filename=($user->code_prefix??'SAM').'-'.time().'-'.rand(11,99).'.csv';
        $payload=[
            'prefix'=>($user->code_prefix??'SAM'),
            'count'=>(int)$request->count,
            'start'=>(int)$max,
            'filename'=>$filename
        ];

        //var_dump($payload);die;

        try {
            $client = new LambdaClient(
                [
                    'version' => 'latest',
                    'region'  => env('AWS_DEFAULT_REGION'),
                    'credentials'=>[
                        'key'=>env('AWS_ACCESS_KEY_ID'),
                        'secret'=>env('AWS_SECRET_ACCESS_KEY')
                    ]
                ]
            );
            $res=$client->invoke([
                'FunctionName'=>'qrcode-generate',
                'Payload'=>json_encode($payload)
            ]);
            //var_dump($res);die;
            $error=$res->get('FunctionError');
            if($error==''){

                $qrs=QRCode::create([

                    'user_id'=>$user->id,
                    'refid'=>$user->code_prefix.((int) (microtime(true) * 1000)),
                    'sequence_prefix'=>$user->code_prefix,
                    'sequence_start'=>$max,
                    'sequence_end'=>$max+$request->count-1,
                    'total'=>$request->count,
                    'remaining'=>$request->count,
                    'file_path'=>$filename

                ]);
                if($qrs){
                    $user->qr_balance=$user->qr_balance-$request->count;
                    $user->save();
                    return [
                        'status'=>'success',
                        'message'=> 'Qr Codes Created'
                    ];
                }

            }else{

                return [
                    'status'=>'failed',
                    'message'=> 'Something Went Wrong1'
                ];

            }
            //dd($res);
        }catch(LambdaException $e){
            return [
                'status'=>'failed',
                'message'=> 'Something Went Wrong2'
            ];
        }

        return [
            'status'=>'failed',
            'message'=> 'Something Went Wrong3'
        ];

    }



    public function generateNdMapCode(Request $request){

        //return $request->all();

        $request->validate([

            'product_id'=>'required|integer',
            'manufacturer_id'=>'required|integer',
            'count'=>'required|integer|max:1000000',
            'mfg_date'=>'required|date:Y-m-d',
            'exp_date'=>'required|date:Y-m-d',
            'batch_number'=>'required'

        ]);

        $user=auth()->user();

        if($user->plan_expiry<date('Y-m-d')){
            return [
                'status'=>'failed',
                'message'=> 'Your Membership Plan Has Been Expired. Please Renew Your Plan To Use Services'
            ];
        }

        if($user->qr_balance<$request->count)
            return [
                'status'=>'failed',
                'message'=> 'Your Remaining QR Code Balance is '.$user->qr_balance.' only'
            ];

        $max=QRCode::where('user_id', $user->id)->max('sequence_end');
        if(!$max)
            $max=0;
        $max=$max+1;
        //echo $max; die;
        $filename=($user->code_prefix??'SAM').'-'.time().'-'.rand(11,99).'.csv';
        $payload=[
            'prefix'=>($user->code_prefix??'SAM'),
            'count'=>(int)$request->count,
            'start'=>(int)$max,
            'filename'=>$filename
        ];

        //var_dump($payload);;die;

        try {
            $client = new LambdaClient(
                [
                    'version' => 'latest',
                    'region'  => env('AWS_DEFAULT_REGION'),
                    'credentials'=>[
                        'key'=>env('AWS_ACCESS_KEY_ID'),
                        'secret'=>env('AWS_SECRET_ACCESS_KEY')
                    ]
                ]
            );
            $res=$client->invoke([
                'FunctionName'=>'qrcode-generate',
                'Payload'=>json_encode($payload)
            ]);

            $error=$res->get('FunctionError');
            if($error==''){
                $user->qr_balance=$user->qr_balance-$request->count;
                $user->save();

                $qrcodes=QRCode::create([

                    'user_id'=>$user->id,
                    'refid'=>$user->code_prefix.((int) (microtime(true) * 1000)),
                    'sequence_prefix'=>$user->code_prefix,
                    'sequence_start'=>$max,
                    'sequence_end'=>$max+$request->count,
                    'total'=>$request->count,
                    'remaining'=>$request->count,
                    'file_path'=>$filename

                ]);
                if($qrcodes){
                    $mappedqr=MappedCode::create([
                        'user_id'=>$user->id,
                        'product_id'=>$request->product_id,
                        'manufacturer_id'=>$request->manufacturer_id,
                        'marketer_id'=>$request->marketer_id,
                        'mapped_id'=>$qrcodes->id,
                        'prefix'=>$user->code_prefix,
                        'sequence_start'=>$max,
                        'sequence_end'=>$max+$request->count,
                        'total'=>$request->count,
                        'batch_number'=>$request->batch_number,
                        'manufactured_date'=>$request->mfg_date,
                        'expiry_date'=>$request->exp_date,
                        'file_path'=>$filename
                    ]);

                    if($mappedqr){
                        $qrcodes->remaining=0;
                        $qrcodes->save();

                        $user->qr_balance=$user->qr_balance-$request->count;
                        $user->save();

                        return [
                            'status'=>'success',
                            'message'=> 'Qr Codes Created'
                        ];
                    }
                }

                return [
                    'status'=>'failed',
                    'message'=> 'Something Went Wrong'
                ];

            }else{
                return [
                    'status'=>'failed',
                    'message'=> 'Something Went Wrong'
                ];
            }
            //dd($res);
        }catch(LambdaException $e){
            return [
                'status'=>'failed',
                'message'=> 'Something Went Wrong'
            ];
        }

        return [
            'status'=>'failed',
            'message'=> 'Something Went Wrong'
        ];

    }


    public function unmapCodes(Request $request, $id){

        $user=auth()->user();

        if($user->plan_expiry<date('Y-m-d')){

            return redirect()->back()->with('error', 'Your Membership Plan Has Been Expired. Please Renew Your Plan To Use Services');

        }

        $mappedcodes=MappedCode::findOrFail($id);

        if(!$mappedcodes->can_be_unmapped){
            return redirect()->back()->with('error', 'This Mapping Cannot Be Unmapped Now');
        }

        $count=$mappedcodes->total;
        $mapped_id=$mappedcodes->mapped_id;

        $qrcode=QRCode::find($mapped_id);
        $qrcode->remaining=$qrcode->remaining+$count;
        $qrcode->save();

        $mappedcodes->delete();

        return redirect()->back()->with('success', 'Qr Codes Have Been Unmapped');

    }

    public function mappedCodes(Request $request){

        $user=auth()->user();

        $codes=MappedCode::with(['product','manufacturer'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->get();

        $products=CompanyProducts::select('name', 'sku', 'sku_size', 'id')
            ->get();
        $manufacturers=Manufacturers::where('user_id', $user->id)
            ->select('m_name', 'id')
            ->get();

        $marketers=Marketer::where('user_id', $user->id)
            ->select('name', 'id')
            ->get();

        return view('portal.mapped-qrcodes', compact('codes', 'user','products', 'manufacturers', 'marketers'));

    }


    public function mapCodes(Request $request){
        //return $request->all();
        $user=auth()->user();

        $request->validate([
            'product_id'=>'required|integer',
            'manufacturer_id'=>'required|integer',
            'start_code'=>'required',
            'end_code'=>'required',
            'mfg_date'=>'required|date:Y-m-d',
            'exp_date'=>'required|date:Y-m-d',
            'batch_number'=>'required'
        ]);


        $start_seq=QRCode::where('is_expired', false)
            ->min('sequence_start');
        if(!$start_seq)
            $start_seq=0;
        $start_seq=$start_seq+1;
        //echo $start_seq;

        if($start_seq > $request->start_code || $request->end_code < $request->start_code)
            return [
                'status'=>'failed',
                'message'=>'You have entered invalid sequences'
            ];
        //die;
        //DB::enableQueryLog();
        $count=MappedCode::where(function($query) use($request){
            $query->where('sequence_start', '>=', $request->start_code)
                ->where('sequence_end', '<=', $request->end_code);
        })->orWhere(function($query) use($request){
            $query->where('sequence_start', '<=', $request->start_code)
                ->where('sequence_end', '<=', $request->end_code)
                ->where('sequence_end', '>=', $request->start_code);
        })->orWhere(function($query) use($request){
            $query->where('sequence_start', '>=', $request->start_code)
                ->where('sequence_end', '>=', $request->end_code)
                ->where('sequence_start', '<=', $request->end_code);
        })->orWhere(function($query) use($request){
            $query->where('sequence_start', '<=', $request->start_code)
                ->where('sequence_end', '>=', $request->end_code);
        })->count();

        //var_dump(DB::getQueryLog());

        //echo $count;die;
        if($count)
            return [
                'status'=>'failed',
                'message'=>'Some of the code sequences are already mapped. If you want to use these sequences please unmap these'
            ];
        //die;
        $master_sequence=QRCode::where('sequence_start', '<=', $request->start_code)
            ->where('sequence_end', '>=', $request->end_code)
            ->first();

        if(!$master_sequence)
            return [
                'status'=>'failed',
                'message'=>'Please select a valid sequence from suggestions'
            ];

        $filename=($user->code_prefix??'SAM').'-'.time().'-'.rand(11,99).'.csv';
        $payload=[
            'prefix'=>($user->code_prefix??'SAM'),
            'count'=>$request->end_code-$request->start_code+1,
            'start'=>$request->start_code,
            'filename'=>$filename
        ];
        //var_dump($payload);die;
        try {
            $client = new LambdaClient(
                [
                    'version' => 'latest',
                    'region'  => env('AWS_DEFAULT_REGION'),
                    'credentials'=>[
                        'key'=>env('AWS_ACCESS_KEY_ID'),
                        'secret'=>env('AWS_SECRET_ACCESS_KEY')
                    ]
                ]
            );
            $res=$client->invoke([
                'FunctionName'=>'qrcode-generate',
                'Payload'=>json_encode($payload)
            ]);

            $error=$res->get('FunctionError');
            if($error==''){

                MappedCode::create([
                    'product_id'=>$request->product_id,
                    'user_id'=>$user->id,
                    'manufacturer_id'=>$request->manufacturer_id,
                    'mapped_id'=>$master_sequence->id,
                    'prefix'=>$user->code_prefix,
                    'sequence_start'=>$request->start_code,
                    'sequence_end'=>$request->end_code,
                    'total'=>$request->end_code-$request->start_code+1,
                    'batch_number'=>$request->batch_number,
                    'manufactured_date'=>$request->mfg_date,
                    'expiry_date'=>$request->exp_date,
                    'file_path'=>$filename
                ]);

                $master_sequence->remaining=$master_sequence->remaining-($request->end_code-$request->start_code+1);
                $master_sequence->save();

                return [
                    'status'=>'success',
                    'message'=>'QR Codes have been mapped'
                ];
            }else{
                return [
                    'status'=>'failed',
                    'message'=>'Some Error Occurred'
                ];
            }
            //dd($res);
        }catch(LambdaException $e){
            return [
                'status'=>'failed',
                'message'=>'Some Error Occurred'
            ];
        }
    }


    public function getProductInfo(Request $request, $prefix, $code){

//        $prefix=substr($code, 0, 4);
//        $code=substr($code, 4);

//        echo $prefix.'-';
//        echo intval($code);
//
//        die;

        $unique_code=$prefix.$code;

        $code=intval($code);

        $code1=MappedCode::with(['product', 'manufacturer'])
            ->where('sequence_start', '<=', $code)
            ->where('sequence_end', '>=', $code)
            ->where('prefix', $prefix)
            ->first();

        if(!$code1)
        {
            $code1=QRCode::where('sequence_start', '<=', $code)
                ->where('sequence_end', '>=', $code)
                ->where('sequence_prefix', $prefix)
                ->first();
        }

        $user=User::find($code1->user_id??'');
        if(!$user)
            abort(404);

        return view('portal.product-detail', compact('code1', 'unique_code','user'));


        //MappedCode::where('prefix', )
    }
}
