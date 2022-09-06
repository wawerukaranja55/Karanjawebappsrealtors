<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Mpesapayments_controller;

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

// pay rent with mpesa
Route::get('/mpesa/password', [Mpesapayments_controller::class,'lipanampesapassword'])->name('lipanampesapassword');

Route::post('/mpesa/newaccesstoken', [Mpesapayments_controller::class,'newaccesstoken'])->name('newaccesstoken');

Route::post('/mpesa/stkpush', [Mpesapayments_controller::class,'stkpush'])->name('stkpush');

// Route::post('/mpesa/storedb', [Mpesapayments_controller::class,'mpesaresponse'])->name('mpesaresponse');

Route::post('/mpesa/stkpush/callbackurl', [Mpesapayments_controller::class,'mpesaresponse'])->name('mpesaresponse');
