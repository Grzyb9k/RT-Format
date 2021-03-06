<?php

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

Route::apiResource('invoice', \App\Http\Controllers\InvoiceController::class);
Route::apiResource('seller', \App\Http\Controllers\SellerController::class);
Route::apiResource('customer', \App\Http\Controllers\CustomerController::class);
Route::apiResource('product', \App\Http\Controllers\ProductController::class);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
