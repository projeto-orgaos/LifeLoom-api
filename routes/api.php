<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\OrganTypeController;
use App\Http\Controllers\OrganController;
use App\Http\Controllers\AddressController;

// Rotas relacionadas à autenticação
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout'); // Removido o middleware auth:sanctum
});

Route::prefix('addresses')->group(function () {
    Route::get('/', [AddressController::class, 'index'])->name('address.index');
    Route::get('/{id}', [AddressController::class, 'show'])->name('address.show');
    Route::post('/', [AddressController::class, 'store'])->name('address.store');
    Route::put('/{id}', [AddressController::class, 'update'])->name('address.update');
    Route::delete('/{id}', [AddressController::class, 'destroy'])->name('address.destroy');
});


// User Routes
Route::prefix('users')->group(function () {
    // List all users
    Route::get('/', [UserController::class, 'index'])->name('users.index');

    // Get user details
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');

    // Create a new user
    Route::post('/', [UserController::class, 'store'])->name('users.store');

    // Update a user
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');

    // Delete a user
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // List organs associated with the user
    Route::get('/{id}/organs', [UserController::class, 'listOrgans'])->name('users.listOrgans');

    // Update organs for a user (select for donation/receipt)
    Route::put('/update-organs/{id}', [UserController::class, 'updateOrgans'])->name('users.updateOrgans');

});

// Rotas relacionadas a hospitais
Route::prefix('hospitals')->group(function () {
    Route::get('/', [HospitalController::class, 'index'])->name('hospitals.index');
    Route::get('/{id}', [HospitalController::class, 'show'])->name('hospitals.show');
    Route::post('/', [HospitalController::class, 'store'])->name('hospitals.store'); // Removido auth:sanctum
    Route::put('/{id}', [HospitalController::class, 'update'])->name('hospitals.update'); // Removido auth:sanctum
    Route::delete('/{id}', [HospitalController::class, 'destroy'])->name('hospitals.destroy'); // Removido auth:sanctum
});

// Rotas relacionadas a tipos de órgãos
Route::prefix('organ-types')->group(function () {
    Route::get('/', [OrganTypeController::class, 'index'])->name('organ-types.index');
    Route::get('/{id}', [OrganTypeController::class, 'show'])->name('organ-types.show');
    Route::post('/', [OrganTypeController::class, 'store'])->name('organ-types.store');
    Route::put('/{id}', [OrganTypeController::class, 'update'])->name('organ-types.update');
    Route::delete('/{id}', [OrganTypeController::class, 'destroy'])->name('organ-types.destroy');
});

// Organ Routes
Route::prefix('organs')->group(function () {
    // List all organs
    Route::get('/', [OrganController::class, 'index'])->name('organs.index');

    // List available organs
    Route::get('/available', [OrganController::class, 'available'])->name('organs.available');

    // Get organ statistics (KPIs)
    Route::get('/kpi', [OrganController::class, 'kpi'])->name('kpi');

    // List donors
    Route::get('/donors', [OrganController::class, 'donors'])->name('organs.donors');

    // List users on the waiting list
    Route::get('/waiting-list', [OrganController::class, 'waitingList'])->name('organs.waiting-list');

    // Create a new organ
    Route::post('/', [OrganController::class, 'store'])->name('organs.store');
});
