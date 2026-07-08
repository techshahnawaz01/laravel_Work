<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Auth\AdminAuthController;

/*
|--------------------------------------------------------------------------
| Super Admin Authentication Routes (Public)
|--------------------------------------------------------------------------
*/
Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AdminAuthController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Super Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->group(function () {
    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('logout', [AdminAuthController::class, 'logout'])->name('logout');

    // Tenant Management - Web Routes
    Route::get('tenants', [TenantController::class, 'indexWeb'])->name('tenants.index');
    Route::get('tenants/create', [TenantController::class, 'createWeb'])->name('tenants.create');
    Route::get('tenants/{id}', [TenantController::class, 'showWeb'])->name('tenants.show');
    Route::get('tenants/{id}/edit', [TenantController::class, 'editWeb'])->name('tenants.edit');

    // Tenant Management - API Routes
    Route::post('tenants', [TenantController::class, 'store'])->name('tenants.store');
    Route::put('tenants/{id}', [TenantController::class, 'update'])->name('tenants.update');
    Route::delete('tenants/{id}', [TenantController::class, 'destroy'])->name('tenants.destroy');
    Route::post('tenants/{id}/initialize', [TenantController::class, 'initialize'])->name('tenants.initialize');
    Route::post('tenants/{id}/activate', [TenantController::class, 'activate'])->name('tenants.activate');
    Route::post('tenants/{id}/deactivate', [TenantController::class, 'deactivate'])->name('tenants.deactivate');
});