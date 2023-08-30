<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Influencer_category;
use App\Models\Reels;
use App\Models\Order_Reels;
use App\Models\Influencer;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Stripe\Stripe;



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
                $user->role_id = $request->role === 'user' ? 2 : 3; // user id is 2 , influencer id is 3
                // $user->father_name = 'fathername';
                // $user->age = 'age';
                // $user->gender = 'gender';
                $user->email = $request->email;
                $user->phone_no = $request->phone_no;
                $user->image = asset("theme/images/avatar.jpg");
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

                if($user->role_id == 3){
                    $influencer = new Influencer();
                    $influencer->user_id = $user->id;
                    $influencer->rate_per_reel = $request->rate_per_reel;
                    $influencer->save();

                    $influencer_category = new Influencer_category();
                    $influencer_category->user_id = $user->id;
                    $influencer_category->category_id = $request->category_id;
                    $influencer_category->influencer_id = $influencer->id;
                    $influencer_category->save();
                }

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
                        'email' => $request->email,
                        // 'role_id' => 2
                    ])->get([
                        'access_token',
                        'id',
                        'name',
                        'email',
                        'role_id',
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
                $root = asset();
                $videoPath = $this->moveVideoAndGetPaths($video, $root, 'videos');

                // Save the video path in the database or perform any other necessary actions
                $reel = New Reels();
                $reel->url = $videoPath;
                $reel->likes = 1;
                $reel->save();
                if($request->order_id != 0){
                $order_reels = New Order_Reels();
                $order_reels->order_id = $request->order_id;
                $order_reels->reels_id =   $reel->id;
                $order_reels->save();
                }
                else if($request->order_id == 0){
                $user_reels = New User_Reels();
                $user_reels->reels_id = $reel->id;
                $user_reels->user_id = $request->user_id;
                $user_reels->save();

                }
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

    public function moveVideoAndGetPaths($file, $root, $folder)
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
    
        // $file_n = $request->file()->name();
        // $file_n_arr = explode('.',$file_n);
        // $exten = $file_n_arr[count($file_n_arr)-1];
        // $filename = time().'.'.$exten;// . '.webm'; // Manually set the extension to "webm"

        // $file_n = $request->file()->name();
        $filename = time(). '.webm'; // Manually set the extension to "webm"
        try {
            $file->move($destinationPath, $filename);
        } catch (\Exception $e) {
            throw new \RuntimeException('Error moving the uploaded file: ' . $e->getMessage(), 500);
        }
    
        return $destinationPath . '/' . $filename;
    }


    public function get_category(){
        try {
            $category = Category::paginate(100,['id','name','avatar']);
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
    public function get_people($category_id){
        try {
            // $category = Category::where('id',$id)->paginate(10,['id','name','avatar']);
            $users = Influencer_category::where('category_id',$category_id)->with('user')->get();
            // ->paginate(10,['id','name','avatar']);

             $users->transform(function($item){
                return $item->user;
            });
            return $this->sendResponse(200, $users);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    }
    public function get_category_people($id){
        try {
            // $category = Influencer_category::where('id',$id)->paginate(10,['id','name','avatar']);
            $category = Influencer_category::where('category_id',$id)->with('user')->paginate(10);
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
    public function get_reel_rate($id){
        try {
           
            // $user_id = $request->user_id;
            $category = Influencer::where('user_id',$id)->with('user')->first();
            // $category = $category->items();
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

    public function submit_payment(Request $request){

    try {
        // 
        $user_id = $request->user_id;
        $influencer_user_id =  $request->influencer_user_id;
        // 
        $influencer = Influencer::where('user_id',$influencer_user_id)->with('user')->first();

        $amount = ($influencer->rate_per_reel * $request->reels_count);
        \Stripe\Stripe::setApiKey(config('services.stripe.STRIPE_SECRET'));
        $paymentIntent = \Stripe\PaymentIntent::create([
            // 'amount' => 50,
            'amount' => $amount,
            'currency' => 'usd',
            // ... other relevant payment details
        ]);
        $payment = new Payment();
        $payment->payment_id = $paymentIntent->id;
        $payment->payment_response = json_encode($paymentIntent); // Save the full response for reference
        $payment->status = $paymentIntent->status;
        $payment->payment_type = $paymentIntent->payment_method_types[0]; // Assuming you're only using one payment method
        $payment->amount = $amount;
        $payment->save();

        $order = new Order();
        $order->user_id = $user_id;
        $order->user_influencer_id = $influencer_user_id;
        $order->status = 'pending';
        $order->comments = $request->comments;
        $order->payment_id = $payment->id;
       
        $order->save();

        return $this->sendResponse(200, ['message' => 'Payment submitted successfully']);

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

