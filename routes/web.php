<?php

use App\Http\Controllers\Backend\BusinessController;
use App\Http\Controllers\Backend\CashbookController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\DesignationController;
use App\Http\Controllers\Backend\FaqController;
use App\Http\Controllers\Backend\TransactionController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();



Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('designations', DesignationController::class, ['names' => 'admin.designations']);
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);
    Route::resource('customers', CustomerController::class, ['names' => 'admin.customers']);
    Route::resource('cashbooks', CashbookController::class, ['names' => 'admin.cashbooks']);
    Route::resource('transactions', TransactionController::class, ['names' => 'admin.transactions']);
    Route::resource('business', BusinessController::class, ['names' => 'admin.business']);
    Route::resource('faqs', FaqController::class, ['names' => 'admin.faqs']);

    
   
    // block user 
    Route::post('/user-block/{id}', [App\Http\Controllers\Auth\UserController::class, 'userBlock'])->name('user.block');

    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
   // Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    //Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});