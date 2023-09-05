<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Category;
use App\Models\Influencer_category;
use App\Models\Influencer;
use App\Models\Order;
use App\Models\Reels;
use App\Models\Order_Reels;
use App\Models\Payment;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;
use Stripe\Stripe;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use FFMpeg\FFMpeg;
use FFMpeg\Coordinate\TimeCode;

    


class InfluencerController extends Controller
{
    
  // FOR Influencer OPEN
    public function get_orders_list($id){
        try {
            $user_influencer_id = $id;
            $order_list = Order::where('user_influencer_id',$user_influencer_id)->with('user','influencer')->paginate(10);
            // $user_influencer = Influencer::where('');
            $order_list = $order_list->items();
            // $responseData = [
            //     'order_list' => $order_list,
            //     'user_influencer' => $user_influencer,
            // ];
            return $this->sendResponse(200, $order_list);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    }

    public function get_orders_reels($id){
        try {
            $order_id = $id;
            $order_reels = Order_Reels::where('order_id', $order_id)->get();
            $order = Order::find($order_id);
            $order_quantity = $order->quantity;
            $reels_urls = [];
        
            foreach ($order_reels as $reels) {
                $reel = Reels::find($reels->reels_id);
        
                if ($reel) {
                    $reels_urls[] = array(
                        'reels_id' => $reel->id,
                        'reels_url' => $reel->url,
                        'order_quantity' => $order_quantity,
                    );
        
                    // Get associated order items for the current reel
                    $order_list = $reel->items;
        
                    // Append order items to the response array
                    $reels_urls[count($reels_urls) - 1]['order_items'] = $order_list;
                }
            }
        
        
            return $this->sendResponse(200, $reels_urls);
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
        


    }
    
    public function delete_reel($id)
    {
        try {
            $reel = Reels::find($id);
    
            if (!$reel) {
                throw new \Exception('Reel not found.', 404);
            }
    
            $order_reels = Order_Reels::where('reels_id', $id)->get();
    
            foreach ($order_reels as $order_reel) {
                $order_reel->delete();
            }
    
            $reel->delete();
    
            return $this->sendResponse(200, ['message' => 'Reel and associated order reels deleted successfully']);
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
    }

    public function deliver_reels($id){
        try {
            $order_id = $id;
            $order =  Order::find($order_id);
            $order->status = 'review';
           
            $order->save();
            return $this->sendResponse(200, $order);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    }
  // FOR Influencer CLOSE


 // FOR USER  OPEN
    public function get_order_reviews($id){
        try {
            $user_id = $id;
            $get_order_reviews = Order::where('user_id', $user_id)->paginate(10);
            $get_order_reviews = $get_order_reviews->items();
            return $this->sendResponse(200, $get_order_reviews);
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
        


    }
    public function get_order_reels_user($id) {
        try {
            $order_id = $id;
            $order_reels = Order_Reels::where('order_id', $order_id)->get();
            $order = Order::find($order_id);
            $order_status = $order->status;
            $reels_data = [];
    
            foreach ($order_reels as $reels) {
                $reel = Reels::find($reels->reels_id);
    
                if ($reel) {
                    $reelData = [
                        'reels_id' => $reel->id,
                        'reels_url' => $reel->url,
                    ];
    
                    // Generate a thumbnail for the video reel's URL
                    // $file =  $reel->url;
                    // $thumbnailAndImageUrls = $this->generateThumbnailAndMoveImage($reel->url, public_path(), 'thumbnails');
                    // $reelData['thumbnail_url'] = $thumbnailAndImageUrls['thumbnail_url'];
              
    
                    // Get associated order items for the current reel
                    $order_list = $reel->items;
    
                    // Append order items to the response array
                    $reelData['order_items'] = $order_list;
                    $reelData['order_status'] = $order_status;
    
                    $reels_data[] = $reelData;
                }
            }
    
            return $this->sendResponse(200, $reels_data);
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
    }
    
    public function generateThumbnailAndMoveImage($videoUrl, $root, $folder)
{
    $ffmpeg = FFMpeg::create([
        'ffmpeg.binaries'  => env('FFMPEG_BINARY'),
        'ffprobe.binaries' => env('FFPROBE_BINARY'),
    ]);

    if (!file_exists($root) || !is_dir($root)) {
        throw new \InvalidArgumentException('Destination root folder does not exist or is not a directory.', 400);
    }

    $thumbnailFilename = 'thumbnail_' . uniqid() . '.jpg';
    $thumbnailPath = $root . '/' . $folder . '/' . $thumbnailFilename;

    $video = $ffmpeg->open($videoUrl);

    // Generate a thumbnail at 1 second into the video and save it
    $video->frame(TimeCode::fromSeconds(1))
          ->save($thumbnailPath);

    // Move the generated thumbnail to the destination folder
    $movedThumbnailUrl = $this->move_img_get_path_thumnail($thumbnailPath, $root, $folder, $thumbnailFilename);

    // Move and get the URL for the provided image
    

    return [
        'thumbnail_url' => $movedThumbnailUrl,
     
    ];
}

    
    
    
    
    public function reels_accepetd($id){
        try {
            $order_id = $id;
            $order =  Order::find($order_id);
            $order->status = 'accepted';
        
            $order->save();
            return $this->sendResponse(200, $order);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    } 

    // orders_available
    public function orders_available($id){
        try {
            $user_id = $id;
            $order =  Order::where('user_id',$user_id)->first();
            if($order){
                $orders = 'available';
            }
            else{
            $orders = 'no_available';
            }

        
            return $this->sendResponse(200, $orders);
        } 
        
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }


    } 

    public function get_profile($id)
    {
        try {
            $user = $id;

            if ($user) {
                $user = User::find($user);
                return $this->sendResponse(200, $user);
            } else {
                return $this->sendResponse(
                    Config::get('error.code.INTERNAL_SERVER_ERROR'),
                    null,
                    ['Wrong OTP'],
                    Config::get('error.code.INTERNAL_SERVER_ERROR')
                );
            }
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
    }

    public function user_update_profile(Request $request ,$id)
    {
        try {
            $user = $id;

            if ($user) {
                $user = User::find($user);
                $user->name = $request->name;
                $user->last_name = $request->last_name;
                $user->email = $request->email;
                $user->phone_no = $request->phone_no;
                $user->save();
                return $this->sendResponse(200, $user);
            } else {
                return $this->sendResponse(
                    Config::get('error.code.INTERNAL_SERVER_ERROR'),
                    null,
                    ['Wrong OTP'],
                    Config::get('error.code.INTERNAL_SERVER_ERROR')
                );
            }
        } catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }
    }

    public function upload_image(Request $request, $id)
    {

        try {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust file formats and size
        ]);
    
        if ($request->hasFile('image')) {
            $avatar = $request->image;
            $root = $request->root();
            $user = User::find($id);
            $user->image = $this->move_img_get_path($avatar, $root, 'image');
            $user->save();
           
        }
        return $this->sendResponse(200, $user);
        }
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }

    }
    public function my_save_reels(Request $request, $id)
    {

        try {
            if ($request->hasFile('video')) {

            $video = $request->file('video');
            $root = $request->root();
            $videoPath = $this->move_img_get_path($video, $root, 'videos');
            // Save the video path in the database or perform any other necessary actions
            $reel = New Reels();
            $reel->url = $videoPath;
            $reel->likes = 1;
            $reel->save();
            // 
            $user_reels = New User_Reels();
            $user_reels->reels_id = $reel->id;
            $user_reels->user_id = $id;
            $user_reels->save();
           
        }
        return $this->sendResponse(200, $reel);
        }
        catch (\Exception $e) {
            return $this->sendResponse(
                500,
                null,
                [$e->getMessage()]
            );
        }

    }
    
    // public function upload_order_reels(Request $request, $id)
    // {

    //     try {
    //         if ($request->hasFile('video')) {

    //         $video = $request->file('video');
    //         $root = asset();
    //         $videoPath = $this->moveVideoAndGetPaths($video, $root, 'videos');
    //         // Save the video path in the database or perform any other necessary actions

    //         $reel = New Reels();
    //         $reel->url = $videoPath;
    //         $reel->likes = 1;
    //         $reel->save();
    //         // 
          
    //         $user_reels = New User_Reels();
    //         $user_reels->reels_id = $reel->id;
    //         $user_reels->user_id = $id;
    //         $user_reels->save();
           
    //     }
    //     return $this->sendResponse(200, $reel);
    //     }
    //     catch (\Exception $e) {
    //         return $this->sendResponse(
    //             500,
    //             null,
    //             [$e->getMessage()]
    //         );
    //     }

    // }

    // public function moveVideoAndGetPaths($file, $root, $folder)
    // {
    //     if (!$file || !$file->isValid()) {
    //         throw new \InvalidArgumentException('Invalid or empty file provided.', 400);
    //     }
    
    //     if (!file_exists($root) || !is_dir($root)) {
    //         throw new \InvalidArgumentException('Destination root folder does not exist or is not a directory.', 400);
    //     }
    
    //     $destinationPath = $root . '/' . $folder;
    
    //     if (!file_exists($destinationPath) || !is_dir($destinationPath)) {
    //         throw new \InvalidArgumentException('Destination folder does not exist or is not a directory.', 400);
    //     }
    
    //     // $file_n = $request->file()->name();
    //     // $file_n_arr = explode('.',$file_n);
    //     // $exten = $file_n_arr[count($file_n_arr)-1];
    //     // $filename = time().'.'.$exten;// . '.webm'; // Manually set the extension to "webm"

    //     // $file_n = $request->file()->name();
    //     $filename = time(). '.webm'; // Manually set the extension to "webm"
    //     try {
    //         $file->move($destinationPath, $filename);
    //     } catch (\Exception $e) {
    //         throw new \RuntimeException('Error moving the uploaded file: ' . $e->getMessage(), 500);
    //     }
    
    //     return $destinationPath . '/' . $filename;
    // }
    
    
    
    


        


}
