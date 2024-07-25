<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// root directory => landing
Route::get('/', function () {
    return Inertia::render('Home');
});

// for admin panel

Route::middleware('auth')->group(function () {
    // main dashboard
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    });

    // package management routes

    // user management

    
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
