<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminFeeController;
use App\Http\Controllers\Admin\CheckoutManagementController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\SettingsController;
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
        
        Route::get('/add-user', [
            UserManagementController::class, 'create'
        ])->name('users.create');

        Route::post('/store-user', [
            UserManagementController::class, 'store'
        ])->name('users.store');

        Route::get('/edit-user/{userId}', [
            UserManagementController::class, 'edit'
        ])->name('users.edit');

        Route::put('/update-user/{userId}', [
            UserManagementController::class, 'update'
        ])->name('users.update');
        
        Route::post('/update-status', [ UserManagementController::class, 'activateUser' ])
            ->name('users.status');
        
        Route::delete('/delete/{userId}', [ UserManagementController::class, 'destroy' ])
            ->name('users.delete');

        // export email
        Route::get('/export-email', [
            UserManagementController::class, 'exportEmails'
        ])->name('users.export');
    });

    Route::prefix('/admin/orders')->group(function(){

        Route::get('/', [ CheckoutManagementController::class, 'index' ])
            ->name('checkout.index');

        // create order
        Route::get('/create-order', [
            CheckoutManagementController::class, 'create'
        ])->name('checkout.create');
        
        // saving order
        Route::post('/store-order', [
            CheckoutManagementController::class, 'store'
        ])->name('checkout.store');

        Route::get('/order/{orderId}', [ CheckoutManagementController::class, 'details' ])
            ->name('checkout.details');
        
        // generate invoice
        Route::get('/generate-invoice/{orderId}', [ InvoiceController::class, 'generateSingleInvoice' ])
            ->name('checkout.invoice');

        // generate statement
        Route::get('/generate-admin-statment', [
            InvoiceController::class, 'statementGeneratorAll'
        ])->name('checkout.invoice');

        // settings update
        Route::get('/settings', [
            SettingsController::class, 'editSettings'
        ])->name('settings.edit');
        
        Route::put('/update-settings', [
            SettingsController::class, 'updateSettings'
        ])->name('settings.update');

    });

    Route::prefix('/admin/payments')->group(function (){
        Route::get('/', [
            AdminFeeController::class, 'index'
        ])->name('payment.index');

        Route::get('/export-dues', [
            AdminFeeController::class, 'downloadFees'
        ])->name('payment.download');

        Route::get('/payment/details/{feeId}', [
            AdminFeeController::class, 'details'
        ])->name('payment.edit');

        Route::put('/payment/update/{feeId}', [
            AdminFeeController::class, 'update'
        ])->name('payment.update');
    });
});

