<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\MembershipController;
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
});