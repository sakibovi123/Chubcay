<?php

use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\Package\PackageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('/checkout', [ CheckoutController::class, 'handleCheckout' ])
    ->name('checkout.handleCheckout');