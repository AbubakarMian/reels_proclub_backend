<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthorizedRequestException;
use App\Libraries\APIResponse;
use Closure;
use DB;

class ValidateClient
{
    use APIResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	$client_id = $request->header('client-id');
    	$authorization_header = $request->header('Authorization');
    	$client_secret = str_replace("Basic ", "", $authorization_header);

        $client = DB::table('client')
                    ->where('client_id', $client_id)
                    ->where('client_secret', $client_secret)
                    ->first();

        if($client){
            return $next($request);
        }

    	try{
    		throw new UnAuthorizedRequestException;
    	}

    	catch(Exception $e) {
    		return $this->sendResponse(Config::get('error.code.INTERNAL_SERVER_ERROR'),
    				[],
    				['User not found'],
    				Config::get('error.code.INTERNAL_SERVER_ERROR'));
    	}
    }
}
