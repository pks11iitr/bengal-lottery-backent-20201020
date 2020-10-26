<?php

namespace App\Http\Controllers\Auth\Api;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Auth $auth, JWTAuth $jwt)
    {
        $this->auth=$auth;
        $this->jwt=$jwt;
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required','string',
            'password' => ['required','string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'mobile' => $data['username'],
            'password' => Hash::make($data['mobile']),
            //'referral_code'=>User::generateReferralCode()
        ]);
    }


    public function login(Request $request){
        $this->validator($request->toArray())->validate();
        $user=$this->ifUserExists($request->username,$request->password);
        if(!$user){
            return response()->json([
                    'status'=>'failed',
                    'message'=>'invalid login attempt',
                    'errors'=>[

                    ],
                ], 200);
            }
        }else{

            return [
                'status'=>'success',
            'message'=>'Login Successfull',
            'token'=>$this->jwt->fromUser($user),
            ];
        }
    }

    protected function ifUserExists($username,$password){
        return (User::where('email', $username)->where('password', Hash::make($password))->where('status',1)->first())??false;
    }


}
