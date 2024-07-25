<?php

use App\Http\Controllers\Checkout\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Package\PackageController;
use App\Http\Controllers\ProfileController;
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

// shift4
Route::post("/checkout", [ CheckoutController::class, 'handleCheckout' ])
    ->name('checkout.handle');



// for admin panel

Route::middleware('auth')->group(function () {

    // main dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    });

    // package management routes
    // Route::get("/packages", [ PackageController::class, "index" ])
    //     ->name("package.index");

    // user management

    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
