<?php

use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\FlareClient\Api;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [App\Http\Controllers\Auth\UserController::class, 'register']);
Route::post('/login', [App\Http\Controllers\Auth\UserController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\Auth\UserController::class, 'logout'])->middleware('auth:api');

Route::apiResource('post', PostController::class)->middleware('auth:api');

Route::get('/send-otp', [App\Http\Controllers\Auth\OtpController::class, 'sendOtp']);
