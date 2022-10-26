<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\BusinessBankController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CashbookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TransactionController;
use App\Models\BankDetails;
use App\Models\BusinessBank;
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

Route::post('register', [App\Http\Controllers\Auth\UserController::class, 'register']);
Route::post('login', [App\Http\Controllers\Auth\UserController::class, 'login']);

//Route::apiResource('post', PostController::class)->middleware('auth:api');

Route::group(['prefix' => 'auth', 'middleware' => 'auth:api'], function(){
    Route::apiResource('post', PostController::class);
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('business', BusinessController::class);
    Route::apiResource('customer-bank', BankDetailsController::class);
    Route::apiResource('business-bank', BusinessBankController::class);
    Route::apiResource('transaction', TransactionController::class);
    Route::get('/transactions-by-customer/{customer}', [\App\Http\Controllers\TransactionController::class, 'tnsCustomer']);
    Route::apiResource('cashbook', CashbookController::class);
    Route::get('/today-cashbook', [App\Http\Controllers\CashbookController::class, 'todayCashbook']);
    Route::get('/week-cashbook', [App\Http\Controllers\CashbookController::class, 'weekCashbook']);
    Route::get('/month-cashbook', [App\Http\Controllers\CashbookController::class, 'monthCashbook']);
    Route::get('/today-cashbook-in', [App\Http\Controllers\CashbookController::class, 'todayCashbookIn']);
    Route::get('/today-cashbook-out', [App\Http\Controllers\CashbookController::class, 'todayCashbookOut']);
    Route::get('/create-cashbook-pdf/{day}', [App\Http\Controllers\CashbookController::class, 'createPdf']);

    // serch api for customer and supplier
    Route::get('/search-customer/{name}', [App\Http\Controllers\CustomerController::class, 'searchCustomer']);
    Route::get('/search-supplier/{name}', [App\Http\Controllers\CustomerController::class, 'searchSupplier']);

    // user update
    Route::put('/user/{user}', [App\Http\Controllers\Auth\UserController::class, 'update'])->name('user.update');
   
    Route::get('/view_reports', [App\Http\Controllers\CashbookController::class, 'viewReports']);


    Route::post('/logout', [App\Http\Controllers\Auth\UserController::class, 'logout'])->middleware('auth:api');
});

Route::post('/send-otp', [App\Http\Controllers\Auth\UserController::class, 'sendOtp']);
Route::post('/check-otp', [App\Http\Controllers\Auth\UserController::class, 'checkOtp']);
Route::get('test', function(){
    return 'test-api';
});
