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
    


}
