<?php

use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Qr\QrController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// root directory => landing
Route::get("/", [ HomeController::class, "home" ])
    ->name("home.home");

// package routes
Route::get("/packages", [ PackageController::class, "index" ])
        ->name("package.index");

// get single package
Route::get("/package/{slug}", [ PackageController::class, 'getSinglePackageDetails' ])
    ->name('package.single');



// for admin panel

Route::middleware('auth')->group(function () {

    // main dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    });

    // get single package
    Route::get("/package/{slug}", [ PackageController::class, 'getSinglePackageDetails' ])
    ->name('package.single');

    // checkout

    Route::post("/checkout", [ CheckoutController::class, 'handleCheckout' ])
        ->name('checkout.handle');

    // shift 4 checkout success & failure
    Route::get("/success", [ CheckoutController::class, "handleSuccess" ])
    ->name('checkout.success');

    Route::get("/failed", [ CheckoutController::class, "handleFailed" ])
    ->name('checkout.failed');

    // generate invoice
    Route::get('/generate-invoice', [ InvoiceController::class, 'generateInvoice' ])
        ->name('invoice.generate');
    
    // generate statement
    Route::get('/generate-statement', [ InvoiceController::class, 'statementGenerator' ])
        ->name('invoice.statement');

    // get qr on mail
    Route::get('/get-qr', [ QrController::class, 'sendQrToMail' ])
        ->name('qr.generate');

    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
require base_path('app/Http/Controllers/Admin/routes/routes.php');

