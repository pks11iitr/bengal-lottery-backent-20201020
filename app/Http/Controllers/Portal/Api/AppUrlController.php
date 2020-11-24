<?php

namespace App\Http\Controllers\Portal\Api;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class AppUrlController extends Controller
{
    public function aboutus(Request $request){

        return view('portal.appurl.about');
    }
    public function privacypolicy(Request $request){

        return view('portal.appurl.privacy_policy');
    }
    public function termscondition(Request $request){

        return view('portal.appurl.termscondition');
    }




}
