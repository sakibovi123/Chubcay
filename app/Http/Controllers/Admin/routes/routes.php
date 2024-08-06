<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CheckoutManagementController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Invoice\InvoiceController;
use Illuminate\Support\Facades\Route;

// admin login
Route::get('/admin-login', [
    AdminController::class, 'adminLoginView'
])->name('admin.loginView');

Route::post('/admin-login', [
    AdminController::class, 'adminLogin'
])->name('admin.login');


// main urls of admin
Route::middleware('admin')->group(function(){
    Route::get('/admin', [ AdminController::class, 'adminIndex' ])
    ->name('admin.index');


    // membership routes
    Route::prefix('membership')->group(function () {
        Route::get('/', [ MembershipController::class, 'memberShipIndex' ])
            ->name('membership.index');
        Route::get('/create', [MembershipController::class, 'createMembership'])
            ->name('membership.create');
        Route::post('/store', [MembershipController::class, 'storeMembership'])
            ->name('membership.store');
        Route::get('/{id}', [MembershipController::class, 'editMembership'])
            ->name('membership.edit');
        Route::put('/{id}', [MembershipController::class, 'updateMembership'])
            ->name('membership.update');
        
        Route::delete('/destroy/{package_id}', [ MembershipController::class, 'destroyPackage' ])
            ->name('membership.destroy');

    });

    // manage users
    Route::prefix('/admin/users')->group(function () {
        Route::get('/', [ UserManagementController::class, 'index' ])
            ->name('users.index');
        
        Route::post('/update-status', [ UserManagementController::class, 'activateUser' ])
            ->name('users.status');
        
        Route::delete('/delete/{userId}', [ UserManagementController::class, 'destroy' ])
            ->name('users.delete');
    });

    Route::prefix('/admin/orders')->group(function(){

        Route::get('/', [ CheckoutManagementController::class, 'index' ])
            ->name('checkout.index');

        Route::get('/order/{orderId}', [ CheckoutManagementController::class, 'details' ])
            ->name('checkout.details');
        
        // generate invoice
        Route::get('/generate-invoice/{orderId}', [ InvoiceController::class, 'generateSingleInvoice' ])
            ->name('checkout.invoice');

        // generate statement
        Route::get('/generate-admin-statment', [
            InvoiceController::class, 'statementGeneratorAll'
        ])->name('checkout.invoice');

    });
});

