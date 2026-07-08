<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Tenant\AuthController;
use App\Http\Controllers\Tenant\DashboardController;
use App\Http\Controllers\Tenant\TaskController;

/*
|--------------------------------------------------------------------------
| Tenant Authentication Routes (Public)
|--------------------------------------------------------------------------
*/
Route::prefix('tenant')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
});

/*
|--------------------------------------------------------------------------
| Protected Tenant Routes (Require Authentication)
|--------------------------------------------------------------------------
*/
Route::middleware('tenant.auth')->group(function () {
    // Authentication
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Task CRUD
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
    });
});