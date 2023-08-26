<?php

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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('logout', function () {
    return view('dashboard');
})->name('admin.logout');


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
Route::resource('users', UserController::class);
Route::post('products.change_status',[ProductController::class,'changeStatus'])->name('products.change_status');
Route::post('users.change_status',[ProductController::class,'changeStatus'])->name('users.change_status');
