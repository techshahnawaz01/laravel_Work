<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TenantController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Tenant\AuthController as TenantAuthController;
use App\Http\Controllers\Tenant\DashboardController as TenantDashboardController;
use App\Http\Controllers\Tenant\TaskController;

Route::get('/', function () {
    if (auth()->guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('admin.login');
});

Route::prefix('admin')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
        Route::post('login', [AdminAuthController::class, 'login']);
    });

    Route::middleware('admin.auth')->group(function () {
        Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::post('logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

        Route::get('tenants', [TenantController::class, 'index'])->name('admin.tenants.index');
        Route::get('tenants/create', [TenantController::class, 'create'])->name('admin.tenants.create');
        Route::post('tenants', [TenantController::class, 'store'])->name('admin.tenants.store');
        Route::get('tenants/{id}/edit', [TenantController::class, 'edit'])->name('admin.tenants.edit');
        Route::put('tenants/{id}', [TenantController::class, 'update'])->name('admin.tenants.update');
        Route::post('tenants/{id}/activate', [TenantController::class, 'activate'])->name('admin.tenants.activate');
        Route::post('tenants/{id}/deactivate', [TenantController::class, 'deactivate'])->name('admin.tenants.deactivate');
    });
});

Route::get('tenant/login', function () {
    $tenant = \App\Models\Tenant::query()->where('status', 'active')->orderBy('name')->first();

    return $tenant
        ? redirect()->route('tenant.login', ['tenant' => $tenant->slug])
        : redirect()->route('admin.login');
})->name('tenant.login.fallback');

Route::prefix('tenant/{tenant}')->group(function () {
    Route::get('/', function (string $tenant) {
        return auth()->check()
            ? redirect()->route('tenant.dashboard', ['tenant' => $tenant])
            : redirect()->route('tenant.login', ['tenant' => $tenant]);
    })->name('tenant.home');

    Route::middleware('guest:web')->group(function () {
        Route::get('login', [TenantAuthController::class, 'showLogin'])->name('tenant.login');
        Route::post('login', [TenantAuthController::class, 'login']);
    });

    Route::middleware('tenant.auth')->group(function () {
        Route::post('logout', [TenantAuthController::class, 'logout'])->name('tenant.logout');
        Route::get('dashboard', [TenantDashboardController::class, 'index'])->name('tenant.dashboard');
        Route::resource('tasks', TaskController::class)
            ->except(['show'])
            ->names('tenant.tasks');
    });
});
