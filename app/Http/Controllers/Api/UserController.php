<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;


class UserController extends Controller
{
    
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(all(), User::$rules_register);

            if ($validator->fails()) {
                return $this->sendResponse(500, null, $validator->messages()->all());
            } else {

                $user = new User();
                $user->name = $request->fullname;
                // $user->father_name = 'fathername';
                // $user->age = 'age';
                // $user->gender = 'gender';
                $user->phone_no = $request->phone;
                $user->password = Hash::make($request->password);
                // $user->required_tutor_class_id = $required_tutor_class_id;
                // $user->latitude = lat;
                // $user->longitude = long;
                // $user->image = image;
                // $user->location = location;
                // $user->self_rating = rating;
                // $user->nic_image = $nic_image;
                // $user->age = age;
                // $user->role_id = 3;
                // $user->qualification_id = $qualification_id;
                // $user->institute_id = $institute_id;
                $user->save();

                return $this->sendResponse(200, $user);
            }
        }
         catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
    }


    public function login(Request $request)
    {
        try {
            //Request input Validation
            $validation = Validator::make($request->all(), User::$rules);
            // dd($validation);
            if (!$validation->fails()) {
                return $this->sendResponse(
                    Config::get('error.code.BAD_REQUEST'),
                    null,
                    $validation->getMessageBag()->all(),
                    Config::get('error.code.BAD_REQUEST')
                );
            } else {
                $authUser = Auth::attempt([
                    'email' => $request->email,
                    'password' => $request->password
                ]);

                //Get record if user has authenticated
                if ($authUser) {
                    $device = $request->header('client-id');
                    $user = User::where([
                        'email' => $request->email
                    ])->get([
                        'access_token',
                        'id',
                        'name',
                        'email',
                        'avatar',
                        'access_token',
                        'get_notification'
                    ])
                        ->first();

                    $user->access_token = uniqid();
                    $user->device_type = $device;
                    $user->save();
                    $user->get_notification = ($user->get_notification ? true : false);

                    unset($user->device_type);
                    $responseArray =  [
                        'status' => Config::get('constants.status.OK'),
                        'response' => $user,
                        'error' => null,
                        'custom_error_code' => null
                    ];
                } else {
                    $responseArray =  [
                        'status' => Config::get('error.code.NOT_FOUND'),
                        'response' => null,
                        'error' => [Config::get('error.message.USER_NOT_FOUND')],
                        'custom_error_code' => Config::get('error.code.NOT_FOUND')
                    ];
                }

                // end sad

                //Set the JSON response
                $status_code = $responseArray['status'];
                $response = $responseArray['response'];
                $error = $responseArray['error'];
                $custom_error_code = $responseArray['custom_error_code'];

                return $this->sendResponse($status_code, $response, $error, $custom_error_code);
            }
        } catch (\Exception $e) {
            return [
                'status' => Config::get('error.code.INTERNAL_SERVER_ERROR'),
                'response' => null,
                'error' => [$e->errorInfo[2]],
                'custom_error_code' => $e->errorInfo[0]
            ];
        }
    }
}
