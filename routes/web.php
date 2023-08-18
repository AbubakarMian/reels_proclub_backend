<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\InfluncerController;
use App\Http\Controllers\Admin\OrderController;
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





Route::get('admin/login',[AdminController::class, 'index']);
Route::post('admin/checklogin',[AdminController::class, 'checklogin']);
Route::get('admin/dashboard',[AdminController::class, 'dashboard'])->name('dashboard');
Route::get('admin/logout',[AdminController::class, 'logout']);
    //=================================  Category ==========================
Route::get('admin/category', [CategoryController::class, 'index'])->name('category.index');

Route::get('admin/category/create', [CategoryController::class, 'create'])->name('category.create'); //add
Route::post('admin/category/save', [CategoryController::class, 'save'])->name('category.save');

Route::get('admin/category/edit/{id}', [CategoryController::class, 'edit'])->name('category.edit');
Route::post('admin/category/update/{id}', [CategoryController::class, 'update'])->name('category.update');

Route::post('admin/category/delete/{id}', [CategoryController::class, 'delete'])->name('category.delete');

// crop image
Route::post('admin/category_crop_image', [CategoryController::class, 'crop_image'])->name('admin.crop_image');
    
    
    
Route::get('admin/influencer', [InfluncerController::class, 'index'])->name('influncer.index');
Route::get('admin/orders', [OrderController::class, 'index'])->name('orders.index');




