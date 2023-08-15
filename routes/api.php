<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\InfluencerController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('register', 'Api\UserController@register');

Route::group(['middleware' => 'auth.client_token'], function () {

    Route::post('register',[UserController::class, 'register']);
    Route::post('login',[UserController::class, 'login']);
    Route::post('video_upload',[UserController::class, 'uploadWebm']);
    Route::get('get_cat',[UserController::class, 'get_category']);
    Route::get('get_people/{id}',[UserController::class, 'get_people']);
    Route::get('get_category_people/{id}',[UserController::class, 'get_category_people']);
    Route::get('get_reel_rate/{id}',[UserController::class, 'get_reel_rate']);
    Route::post('submit_payment',[UserController::class, 'submit_payment']);
    // get_orders_list
    Route::get('get_orders_list/{id}',[InfluencerController::class, 'get_orders_list']);
    // get_orders_reels_)list
    Route::get('get_orders_reels/{id}',[InfluencerController::class, 'get_orders_reels']);
    Route::delete('delete_reel/{id}',[InfluencerController::class, 'delete_reel']);
    Route::post('deliver_reels/{id}',[InfluencerController::class, 'deliver_reels']);

    
});