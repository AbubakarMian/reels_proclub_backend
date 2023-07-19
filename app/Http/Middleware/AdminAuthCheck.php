<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
class AdminAuthCheck
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
        // dd(Auth::Check());
        // $response = $next($request);
        // return $response;
        $user =Auth::user();
    //    dd('admin auth');
        if(Auth::Check()){
            // dd($user->role_id == 1 );
            if($user->role_id == 1 ){
                $response = $next($request);

                $response->headers->set('Cache-Control','nocache, no-store, max-age=0, must-revalidate');
                $response->headers->set('Pragma','no-cache');
                $response->headers->set('Expires','Sat, 26 Jul 1997 05:00:00 GMT');
                return $response;
            }

            else{
                return redirect('admin/login')->with('error', 'Wrong Login Details');
            }
        }
        else{
            return redirect('admin/login')->with('error', 'Wrong Login Details');
        }
    }
}
