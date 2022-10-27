<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\BusinessController;
use App\Http\Controllers\API\ServiceController;
use App\Http\Controllers\API\BusinessServiceController;
use App\Http\Controllers\API\RatingController;
use App\Http\Controllers\API\ServiceRequestController;
use App\Http\Controllers\API\ConversationController;
use App\Http\Controllers\API\ChatController;
use App\Http\Controllers\API\BankController;

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

Route::post('user/register', [UserController::class, 'register']);
Route::post('user/login', [UserController::class, 'login']);

Route::post('email/verification-notification', [UserController::class, 'resendVerification']);

Route::post('user/getPin', [UserController::class, 'getPin']);
Route::post('user/resetPassword', [UserController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function() {
    Route::post('user/logout', [UserController::class, 'logout']);
    Route::get('user/getData', [UserController::class, 'getData']);
    Route::put('user/update/{id}', [UserController::class, 'update']);
    Route::get('service/statuses/get', [ServiceRequestController::class, 'getStatusses']);
    Route::get('user/getCards', [UserController::class, 'getCards']);
    Route::put('request/pay/{id}', [ServiceRequestController::class, 'pay']);

    Route::apiResources([
        'address' => AddressController::class,
        'business' => BusinessController::class,
        'service' => ServiceController::class,
        'business_service' => BusinessServiceController::class,
        'rating' => RatingController::class,
        'request' => ServiceRequestController::class,
        'conversation' => ConversationController::class,
        'bank' => BankController::class
    ]);
});

Route::group(['middleware' => ['is_pusher'],'prefix' => 'webhook'], function() {
    Route::post('client', [ChatController::class, 'client']);
    Route::post('channel', [ChatController::class, 'channel']);
    Route::post('presence', [ChatController::class, 'presence']);
});
