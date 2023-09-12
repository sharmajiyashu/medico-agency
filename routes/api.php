<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\UserController;

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

Route::get('unauthorized', function () {
    return response()->json(['statusCode' => 401, 'status' => 'unauthorized', 'message' => 'Unauthorized user.']);
})->name('api.unauthorized');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();

});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('get_profile',[UserController::class,'getProfile']);
    Route::get('products',[UserController::class,'products']);
    Route::post('create_order',[UserController::class,'createOrder']);
    Route::get('orders',[UserController::class,'orders']);
    Route::post('order_detail',[UserController::class,'orderDetail']);
    Route::post('update_profile',[UserController::class,'updateProfile']);
    Route::post('generate_summary',[UserController::class,'generateSummary']);
    Route::post('repet_order',[UserController::class,'repetOrder']);
    Route::get('recent_order_products',[UserController::class,'recent_order_products']);

});

Route::post('forget_password',[UserController::class,'resetPassword']);
Route::post('login',[UserController::class,'login']);

