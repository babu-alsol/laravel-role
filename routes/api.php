<?php

use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\BusinessBankController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\CashbookController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FaqController;
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
    Route::apiResource('transaction', TransactionController::class)->except('index');
    Route::get('/get-transaction/{type}', [App\Http\Controllers\TransactionController::class, 'index']);
    Route::get('/transactions-by-customer/{customer}', [\App\Http\Controllers\TransactionController::class, 'tnsCustomer']);
    Route::get('/transactions-by-customer/{supplier}', [\App\Http\Controllers\TransactionController::class, 'tnsSupplier']);
    Route::apiResource('cashbook', CashbookController::class)->except('index');
    Route::get('/cashbook/{start_date?}/{end_date?}', [App\Http\Controllers\CashbookController::class, 'index']);
    Route::get('/today-cashbook', [App\Http\Controllers\CashbookController::class, 'todayCashbook']);
    Route::get('/week-cashbook', [App\Http\Controllers\CashbookController::class, 'weekCashbook']);
    Route::get('/month-cashbook', [App\Http\Controllers\CashbookController::class, 'monthCashbook']);
    Route::get('/today-cashbook-in', [App\Http\Controllers\CashbookController::class, 'todayCashbookIn']);
    Route::get('/today-cashbook-out', [App\Http\Controllers\CashbookController::class, 'todayCashbookOut']);
    Route::get('/create-cashbook-pdf/{start_date?}/{end_date?}', [App\Http\Controllers\CashbookController::class, 'createPdf']);

    // all transactions for a customer/ supplier
     Route::get('/user-all-customers-transactions', [App\Http\Controllers\TransactionController::class, 'customerTransactions']);
     Route::get('/user-all-suppliers-transactions', [App\Http\Controllers\TransactionController::class, 'supplierTransactions']);

    // serch api for customer and supplier
    Route::get('/search-customer/{name}', [App\Http\Controllers\CustomerController::class, 'searchCustomer']);
    Route::get('/search-supplier/{name}', [App\Http\Controllers\CustomerController::class, 'searchSupplier']);

    // user update
    Route::put('/user/{user}', [App\Http\Controllers\Auth\UserController::class, 'update'])->name('user.update');
   
    Route::get('/view_reports', [App\Http\Controllers\CashbookController::class, 'viewReports']);
    Route::get('/view_reports/{type}', [App\Http\Controllers\CashbookController::class, 'viewReportsType']);

    // get all business for a particular user

   // Route::get('/business-for-a-user', [App\Http\Controllers\BusinessController::class, 'getAllBusiness']);



    Route::post('/logout', [App\Http\Controllers\Auth\UserController::class, 'logout'])->middleware('auth:api');
});



Route::post('/send-otp', [App\Http\Controllers\Auth\UserController::class, 'sendOtp']);
Route::post('/check-otp', [App\Http\Controllers\Auth\UserController::class, 'checkOtp']);
Route::get('test', function(){
    return 'test-api';
});

// faq api
Route::resource('faq', FaqController::class)->only(['index', 'show']);
