<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\User;
use Illuminate\Http\Request;

class InfluncerController extends Controller
{
    public function index(){
        $influencer = User::orderBy('created_at', 'ASC')->paginate(10);
        return view('influencer.index', compact('influencer'));
    }
}
