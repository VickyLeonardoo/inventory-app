<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ArrivalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ApplicationController;

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
        ->middleware('role:superadmin');

    Route::resource('location',LocationController::class)
        ->middleware('role:superadmin');

    Route::resource('supplier',SupplierController::class)
        ->middleware('role:superadmin');

    Route::resource('arrival',ArrivalController::class)
        ->middleware('role:superadmin');

        // Custom route terlebih dahulu
    Route::post('/approve/application/{id}', [ApplicationController::class, 'approve'])
        ->name('application.approve')
        ->middleware('role:superadmin');

    Route::resource('application',ApplicationController::class)
        ->middleware('role:superadmin');

});

require __DIR__.'/auth.php';
