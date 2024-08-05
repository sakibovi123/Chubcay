<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MembershipController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;


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
});