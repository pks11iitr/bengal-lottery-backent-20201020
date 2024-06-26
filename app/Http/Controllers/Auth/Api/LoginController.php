<?php

namespace App\Http\Controllers\Auth\Api;

use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{



    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required|string',
        ], ['email.exists'=>'This account is not registered with us. Please signup to continue']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ($token=$this->attemptLogin($request)) {
//            $user=$this->getCustomer($request);
//            $user->notification_token=$request->notification_token;
//            $user->save();
            return $this->sendLoginResponse($request,$this->getCustomer($request), $token);
        }
        return [
            'status'=>'failed',
            'token'=>'',
            'message'=>'Credentials are not correct'
        ];

    }


    protected function attemptLogin(Request $request)
    {
        return Auth::guard('api')->attempt(
            ['email'=>$request->email, 'password'=>$request->password,'status'=>1]
        );
    }

    protected function getCustomer(Request $request){
        return User::where('email',$request->email)->first();
    }

    protected function sendLoginResponse(Request $request,$user, $token){

       $users=User::find($user->id);
       $users->token=$request->fcm_token;
        $users->save();
            return ['status'=>'success','check_password'=>$user->check_password, 'message'=>'Login Successfull', 'token'=>$token];

    }


    /**
     * Handle a login request to the application with otp.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */

 public function updatePassword(Request $request){
        $user=auth()->guard('api')->user();
        if(!$user){
            return [
                'status'=>'failed',
                'message'=>'Please Log in to continue'
            ];
        }

        $user->password=Hash::make($request->password);
        $user->check_password=1;
 if($user->save()){
     return [
         'status'=>'success',
         'message'=>'Password Has Been Updated Successfully. Please log in to continue.'
     ];
 }else{
     return [
         'status'=>'failed',
         'message'=>'Invalid Request'
     ];
 }


    }



}
