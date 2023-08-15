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



class InfluencerController extends Controller
{
    

    public function get_orders_list($id){
        try {
            $user_influencer_id = $id;
            $order_list = Order::where('user_influencer_id',$user_influencer_id)->with('user')->paginate(10);
            $order_list = $order_list->items();
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
            $reels_urls = [];
        
            foreach ($order_reels as $reels) {
                $reel = Reels::find($reels->reels_id);
        
                if ($reel) {
                    $reels_urls[] = array(
                        'reels_id' => $reel->id,
                        'reels_url' => $reel->url,
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
    
    


}
