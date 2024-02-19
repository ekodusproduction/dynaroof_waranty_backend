<?php

use App\Http\Controllers\Customer\RegisteredCustomerController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Settings\ChangePasswordController;
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
    return view('login');
})->name('admin.home');
Route::post('login', [LoginController::class, 'login'])->name('admin.login');

Route::group(['middleware' => 'auth'], function(){
    Route::group(['prefix' => 'dashboard'], function(){
        Route::get('', [DashboardController::class, 'dashboard'])->name('admin.dashboard');
    });
    Route::group(['prefix' => 'customer'], function(){
        Route::get('registered', [RegisteredCustomerController::class, 'getRegisteredCustomer'])->name('admin.get.registered.customer');
        Route::post('get-details', [RegisteredCustomerController::class, 'getCustomerDetails'])->name('admin.get.customer.details');
    });
    Route::group(['prefix' => 'settings'], function(){
        Route::match(['get', 'post' ], 'change-password', [ChangePasswordController::class, 'changePassword'])->name('admin.settings.change.password');
    });
    Route::get('logout', function(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    });
});
