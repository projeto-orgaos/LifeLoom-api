<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HospitalController;
use App\Http\Controllers\OrganTypeController;

// Rotas relacionadas à autenticação
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout'); // Removido o middleware auth:sanctum
});

// Rotas relacionadas a usuários
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');
    Route::get('/{id}', [UserController::class, 'show'])->name('users.show');
    Route::put('/{id}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/{id}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/', [UserController::class, 'store'])->name('users.store');
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
