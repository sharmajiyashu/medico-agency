<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\PaymentStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => 'auth'], function () {


Route::get('/', [LoginController::class,'dashboard'])->name('dashboard');

Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');


Route::group(['as' => 'master.'], function () {
    Route::resource('payment-status', PaymentStatusController::class);
    Route::post('payment-status.change_status',[PaymentStatusController::class,'changeStatus'])->name('payment-status.change_status');
    Route::get('payment_status.change_default_to/{id}',[PaymentStatusController::class,'changeDefaultto'])->name('payment_status.change_default_to');

    Route::resource('payment-mode', PaymentModeController::class);
    Route::post('payment-mode.change_status',[PaymentModeController::class,'changeStatus'])->name('payment-mode.change_status');
    Route::get('payment_mode.change_default_to/{id}',[PaymentModeController::class,'changeDefaultto'])->name('payment_mode.change_default_to');

    Route::resource('order-status', OrderStatusController::class);
    Route::post('order-status.change_status',[OrderStatusController::class,'changeStatus'])->name('order-status.change_status');
    Route::get('order-status.change_default_to/{id}',[OrderStatusController::class,'changeDefaultto'])->name('order-status.change_default_to');
    
});

Route::resource('products', ProductController::class);
Route::resource('orders', OrderController::class);
Route::resource('users', UserController::class);
Route::post('products.change_status',[ProductController::class,'changeStatus'])->name('products.change_status');
Route::post('products.import',[ProductController::class,'import'])->name('products.import');
Route::post('users.change_status',[UserController::class,'changeStatus'])->name('users.change_status');
Route::get('change_payment_status/{order_id}/{id}',[OrderController::class,'change_payment_status'])->name('change_payment_status');
Route::get('change_payment_mode/{order_id}/{id}',[OrderController::class,'change_payment_mode'])->name('change_payment_mode');
Route::get('change_order_status/{order_id}/{id}',[OrderController::class,'change_order_status'])->name('change_order_status');
Route::post('update_order_invoice',[OrderController::class,'updateInvoice'])->name('update_order_invoice');

});

Route::get('login',[LoginController::class,'index'])->name('login');
Route::post('check_login',[LoginController::class,'check_login'])->name('check_login');
Route::get('order-history/{order_id}',[OrderController::class,'orderHistory'])->name('order_history');
Route::get('reset-password/{id}',[LoginController::class,'resetPassword'])->name('reset_password');
Route::post('change_password',[LoginController::class,'change_password'])->name('change_password');

