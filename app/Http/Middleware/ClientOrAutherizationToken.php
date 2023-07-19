<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthorizedRequestException;
use App\Libraries\APIResponse;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ClientOrAutherizationToken
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
        $user = $this->validate_user($request);
        if ($user) {
            return $next($user);
        }
        else{

            $client = $this->validate_client($request);
            if($client){
                return $next($client);
            }
        }

        $client = $this->sendResponse(
            Config::get('error.code.INTERNAL_SERVER_ERROR'),
            [],
            ['Authorization token invalid'],
            Config::get('error.code.INTERNAL_SERVER_ERROR')
        );

        return response($client);

        // try {
        //     $client = $this->validate_client($request);
        // } catch (Exception $e) {
        //     $client = $this->sendResponse(
        //         Config::get('error.code.INTERNAL_SERVER_ERROR'),
        //         [],
        //         ['Authorization token invalid'],
        //         Config::get('error.code.INTERNAL_SERVER_ERROR')
        //     );
        //     return response($client);
        // }


        // return $next($client);
    }

    public function validate_user($request)
    {   $headers = Request::header();
        $authorization_header = $headers['Authorization'] ?? $headers['authorization']??null;
        $authorization_header = $authorization_header ?? $headers['Authorization-secure']?? $headers['authorization-secure'];
        $access_token = str_replace("Bearer ", "", $authorization_header);

        if ($access_token) {
            $user = User::where('access_token', $access_token)->first();
            if ($user) {
                $request->attributes->add(["user" => $user]);
                return $request;
            }

        }
        return false;
    }

    public function validate_client($request)
    {
        $headers = Request::header();
        $client_id = $headers['client-id'];
        $authorization_header = $headers['Authorization'] ?? ($headers['authorization']??null);

        $authorization_header = $authorization_header ?? $headers['Authorization-secure']?? $headers['authorization-secure'];
        $client_secret = str_replace("Basic ", "", $authorization_header);

        $client = DB::table('client')
            ->where('client_id', $client_id)
            ->where('client_secret', $client_secret)
            ->first();
        if ($client) {
            $user['id'] = 0;
            $request->attributes->add(["user" => $user]);
            return $request;
        }
        return false;
    }
}
