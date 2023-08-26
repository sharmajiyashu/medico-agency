<?php

use App\Http\Controllers\PaymentModeController;
use App\Http\Controllers\PaymentStatusController;
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
    
});
