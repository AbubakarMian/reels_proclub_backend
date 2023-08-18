<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = User::orderBy('created_at', 'ASC')->paginate(10);
        return view('orders.index', compact('orders'));
    }
}
