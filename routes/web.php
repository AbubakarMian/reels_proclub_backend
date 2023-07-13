<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');



    Route::get('admin/login',[AdminController::class, 'index']);
    Route::post('admin/checklogin',[AdminController::class, 'checklogin']);
    Route::get('admin/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('admin/logout',[AdminController::class, 'logout']);
    
    



});
