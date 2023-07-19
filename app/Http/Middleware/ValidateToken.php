<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthorizedRequestException;
use App\User;
use Closure;

class ValidateToken
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
    	$req = $this->validateToken($request);
    	
        return $next($req);
    }
    
    /**
     * Validate token
     * 
     * @param mixed $request
     * @throws UnAuthorizedRequestException
     * @return \Illuminate\Http\Request
     */
    protected function validateToken($request) {
//        $authorization = apache_request_headers()["Authorization"];
        $authorization = $request->header('Authorization');

        $access_token = str_replace("Bearer ", "", $authorization);

        if($access_token) {
            $user = User::where('access_token', $access_token)->first();

            if($user) {
                $request->attributes->add(["user" => $user]);
                return $request;
            }
        }

        throw new UnAuthorizedRequestException;
    }
}
