<?php

namespace App\Http\Middleware;

use Closure;

class CheckActiveUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user=auth()->guard('api')->user();
        if(!$user)
            return response()->json([
                'status'=>'failed',
                'message'=>'Please login to continue'
            ], 200);
        if($user->status==0)
            return response()->json([
                'status'=>'failed',
                'message'=>'Account is not active'
            ], 200);
        return $next($request);
    }
}
