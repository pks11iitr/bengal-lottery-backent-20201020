<?php

namespace App\Http\Controllers\Portal;

use App\Models\Marketer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Response;
use App\Models\Manufacturers;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{

	// ALTER TABLE `manufacturers` ADD `state_name` VARCHAR(200) NULL AFTER `city_name`, ADD `phone_no` VARCHAR(10) NULL AFTER `state_name`;
	// ALTER TABLE `manufacturers` CHANGE `state_id` `state_id` VARCHAR(11) NULL DEFAULT NULL;
	// ALTER TABLE `manufacturers` DROP `city_id`;

    public function profile(Request $request){
    	$user = Auth::user();
    	$manufacturers = Manufacturers::where('user_id',$user->id)->get();
    	$marketers=Marketer::where('user_id', $user->id)->get();
    	$states = Config('constant.STATES');
        return view('portal.profile',compact('user','manufacturers','states', 'marketers'));
    }

    public function userslist(Request $request){
        $user = Auth::user();
        $agents = User::where('parent_id',$user->id)->get();
      //  $marketers=Marketer::where('user_id', $user->id)->get();
       // $states = Config('constant.STATES');
        return view('portal.agent.add',compact('agents'));
    }
    public function profileEdit(Request $request) {

    }

    public function profileEditStore(Request $request) {
    	$user = Auth::user();
    	$this->validate($request, array(
            "company_name" => "required",
            "company_email" => "required",
            "company_address" => "required",
            "registration_number" => "required",
            "company_phone" => "required",
            //"marketed_by" => "required",
            "cc_email" => "required",
            "cc_phone" => "required",
            "cc_address" => "required",
        ));

    	$input = $request->all();
    	$user->fill($input)->save();
        \Session::flash("success", "Company Profile Updated successfully");
        return redirect()->route("profile");
    }

    public function manufacturerStore(Request $request) {
    	$user = Auth::user();
    	$this->validate($request, array(
            "m_name" => "required",
            //"m_alias" => "required|unique:manufacturers",
            "m_license" => "required",
            "phone_no" => "required",
            "state_id" => "required",
            "city_name" => "required",
            "m_address" => "required",
            "m_pincode" => "required"
        ));

    	$states = Config('constant.STATES');
        $state_name = isset($states[$request->state_id])?$states[$request->state_id]:'';
        $request->request->add(['state_name' => $state_name]);
	    $request->request->add(['user_id' => $user->id]);
	    $sts = Manufacturers::create($request->all());

	    if($sts) {
            \Session::flash("success", "Manufacturer Added successfully");
            return redirect()->route("profileManufacturers");
        }
    }

    public function getManufactureDetails(Request $request,$id) {
    	$manufacturer = Manufacturers::where("id", $id)->first();
        return Response::json(["manufacturer" => $manufacturer]);
    }

    public function manufacturerEditStore(Request $request) {
    	$user = Auth::user();

    	$this->validate($request, array(
            "m_name" => "required",
            "m_license" => "required",
            "phone_no" => "required",
            "state_id" => "required",
            "city_name" => "required",
            "m_address" => "required",
            "m_pincode" => "required"
        ));

        $states = Config('constant.STATES');
        $state_name = isset($states[$request->state_id])?$states[$request->state_id]:'';
        $request->request->add(['state_name' => $state_name]);

        $input = $request->all();
        $manufacturer = Manufacturers::where("id", $request->id)->first();
    	$manufacturer->fill($input)->save();


        \Session::flash("success", "Manufacturer Details Updated successfully");
        return redirect()->route("profileManufacturers");
    }

    public function changePasswordStore(Request $request) {
    	$user = Auth::user();
    	$this->validate($request, array(
            'current_password' => ['required', new MatchOldPassword],
            "new_password" => "required|same:confirm_password",
            "confirm_password" => "required|same:new_password",
        ));
        User::find($user->id)->update(['password'=> Hash::make($request->new_password)]);
		\Session::flash("success", "Password Updated successfully");
    	return redirect()->route("profileChangePassword");
    }

    public function marketerStore(Request $request){

        $request->validate([

            'name'=>'required|max:150'

        ]);

        $user=auth()->user();

        if(Marketer::create([

            'user_id'=>$user->id,
            'name'=>$request->name

        ])){

            return redirect()->back()->with('success', 'Marketer Has Been Added');

        }




    }

    public function changepassword(Request $request){

        return view('portal.changepassword.changepassword');
    }

    public function updatepassword(Request $request){

        $request->validate([
            'password'=>'required',
            'cpassword'=>'required|same:password',

        ]);

        $user = Auth::user();
      $role=  auth()->user()->hasRole('admin');
      if($role){
          $user->password=Hash::make($request->password);
          $user->save();
      }

        return redirect()->route('dashboard')->with('success', 'Change password Successfully');
    }
}
