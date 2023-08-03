<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Influencer_category;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;


class UserController extends Controller
{
    
    public function register(Request $request)
    {
        try {

            // dd($request->all());
            $validator = Validator::make($request->all(), User::$rules_register);

            if ($validator->fails()) {
                return $this->sendResponse(500, null, $validator->messages()->all());
            } else {

                $user = new User();
                $user->name = $request->fullname;
                // $user->father_name = 'fathername';
                // $user->age = 'age';
                // $user->gender = 'gender';
                $user->email = $request->email;
                $user->phone_no = $request->phone_no;
                $user->password = Hash::make($request->password);
                $user->access_token = uniqid();

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
            if ($validation->fails()) {
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
                        // 'avatar',
                        // 'access_token',
                        // 'get_notification'
                    ])
                        ->first();

                    $user->access_token = uniqid();
                    // $user->device_type = $device;
                    $user->save();
                    $user->get_notification = ($user->get_notification ? true : false);

                    // unset($user->device_type);
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



    // video_upload

    // public function video_upload(Request $request)
    // {
    //     try {
    //         if ($request->hasFile('video')) {
    //             $video = $request->file('video');
    //             $root = public_path();
    //             $videoPath = $this->move_video_get_path($video, $root, 'videos');

    //             // Save the video path in the database
    //             // $videoModel = new Video();
    //             // $videoModel->title = $request->input('title'); // Assuming you have a form field for the video title
    //             // $videoModel->video_path = $videoPath;
    //             // $videoModel->save();
    //         } else {
    //             throw new \Exception('Video file not found.', 400);
    //         }

    //         $res = new stdClass();
    //         $res->video = $videoPath;

    //         return response()->json($res, 200);
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => $e->getCode(),
    //             'response' => null,
    //             'error' => [$e->getMessage()],
    //         ], $e->getCode());
    //     }
    // }


    // public function move_video_get_path($file, $root, $folder)
    // {
    //     $destinationPath = $root . '/' . $folder; // Define the destination folder path
    //     $filename = time() . '.' . $file->getClientOriginalExtension(); // Generate a unique filename
    //     $file->move($destinationPath, $filename); // Move the file to the destination folder

    //     return $destinationPath . '/' . $filename; // Return the full path of the uploaded file
    // }
    public function uploadWebm(Request $request)
    {
        try {


            
            if ($request->hasFile('video')) {

                 $video = $request->file('video');
                $root = public_path();
                $videoPath = $this->moveVideoAndGetPath($video, $root, 'videos');

                // Save the video path in the database or perform any other necessary actions

                return $this->sendResponse(200, ['video_path' => $videoPath]);

                // return response()->json(['video_path' => $videoPath], 200);
            } else {
                throw new \Exception('Video file not found.', 400);
            }
        } 
        
        
        
        catch (\Exception $e) {
            return response()->json([
                'status' => $e->getCode(),
                'response' => null,
                'error' => [$e->getMessage()],
            ], $e->getCode());
        }
    }

    public function moveVideoAndGetPath($file, $root, $folder)
    {
        if (!$file || !$file->isValid()) {
            throw new \InvalidArgumentException('Invalid or empty file provided.', 400);
        }
    
        if (!file_exists($root) || !is_dir($root)) {
            throw new \InvalidArgumentException('Destination root folder does not exist or is not a directory.', 400);
        }
    
        $destinationPath = $root . '/' . $folder;
    
        if (!file_exists($destinationPath) || !is_dir($destinationPath)) {
            throw new \InvalidArgumentException('Destination folder does not exist or is not a directory.', 400);
        }
    
        $file_n = $request->file()->name();
        $file_n_arr = explode('.',$file_n);
        $exten = $file_n_arr[count($file_n_arr)-1];
        $filename = time().'.'.$exten;// . '.webm'; // Manually set the extension to "webm"
    
        try {
            $file->move($destinationPath, $filename);
        } catch (\Exception $e) {
            throw new \RuntimeException('Error moving the uploaded file: ' . $e->getMessage(), 500);
        }
    
        return $destinationPath . '/' . $filename;
    }


    public function get_category(){
        try {
            $category = Category::paginate(10,['id','name','avatar']);
            $category = $category->items();
            return $this->sendResponse(200, $category);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    }
    public function get_people($id){
        try {
            $category = Influencer_category::where('id',$id)->paginate(10,['id','name','avatar']);
            $category = $category->items();
            return $this->sendResponse(200, $category);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    }
    

}
