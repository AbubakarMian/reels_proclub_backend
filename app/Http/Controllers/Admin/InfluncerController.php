<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Influencer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfluncerController extends Controller
{
    public function index()
    {
        
        return view('influencer.index');
    }
    
    public function getUsers($id = 0){
        $users = Influencer::join('users', 'users.id', 'influencer.user_id')
            ->join('influencer_category', 'users.id', 'influencer_category.user_id')
            ->select(
                'users.*',
                'influencer.lat',
                'influencer.long',
                'influencer.is_featured',
                DB::Raw('influencer.id as influencer_id')
            )->get();
        $userData['data'] = $users;

        echo json_encode($userData);

    }

    function set_featured(Request $request,$influencer_id){

        $influencer = Influencer::find($influencer_id);
        $influencer->is_featured = !$influencer->is_featured;
        $influencer->save();

        return $this->sendResponse(200,$influencer);

    }
}