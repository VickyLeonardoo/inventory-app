<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\ItemApplicationController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('item',ItemController::class)
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::resource('location',LocationController::class)
        ->middleware('role:superadmin|admin');

    Route::resource('supplier',SupplierController::class)
        ->middleware('role:superadmin|admin');

    Route::resource('arrival',ArrivalController::class)
        ->middleware('role:superadmin|admin');

        // Custom route terlebih dahulu
    Route::put('/approve/application/{application}', [ApplicationController::class, 'approve'])
        ->name('application.approve')
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::put('/pending/application/{application}', [ApplicationController::class, 'pending'])
        ->name('application.pending')
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::put('/reject/application/{application}', [ApplicationController::class, 'reject'])
        ->name('application.reject')
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::resource('application',ApplicationController::class)
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::delete('/application/item/{item}', [ItemApplicationController::class, 'delete'])
        ->name('application.item.delete')
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::resource('application.item',ItemApplicationController::class)
        ->middleware('role:superadmin|admin|staff|supervisor');

    Route::resource('user',UserController::class)
        ->middleware('role:superadmin|admin');

});

require __DIR__.'/auth.php';
