<?php

namespace App\Http\Controllers\Auth;

use App\Models\Plans;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
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

    use RegistersUsers;

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
    public function __construct()
    {
        $this->middleware('guest');
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'mobile'=>['required', 'digits:10'],
            'company'=>['required', 'string', 'max:255'],
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
        $plan=Plans::where('is_trial', true)
            ->first();

        $prefix=self::generatePrefix();

        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'current_plan'=>$plan->id,
            'plan_expiry'=>date('Y-m-d', strtotime('+15 days')),
            'qr_balance'=>$plan->count,
            'code_prefix'=>$prefix,
            'mobile'=>$data['mobile'],
            'company_name'=>$data['company']
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('auth.my-register');
    }


    public static function generatePrefix(){

        do{
            $prefix=chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90)).chr(rand(65,90));

        }while(User::where('code_prefix', $prefix)->count());

        return $prefix;

    }

    public function register(Request $request)
    {
        //var_dump($request->all());die;
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath())->with('success', 'Your Basic Trial Plan with 2500 QR Code limit is active now. You can upgrade your plan anytime. Please Complete Your Profile Information To Generate QR Codes');
    }

    public function redirectPath()
    {
        return route('profile');
    }
}
