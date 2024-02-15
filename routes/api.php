<?php

use App\Http\Controllers\Customer\RegisteredCustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('customer-registration', [RegisteredCustomerController::class, 'registration']);
Route::post('verify-otp', [RegisteredCustomerController::class, 'verifyOTP']);
