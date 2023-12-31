<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::with('user','influencer')->orderBy('created_at', 'desc')->paginate(35);
        return view('orders.index', compact('orders'));
    }
}
