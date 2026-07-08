<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\TenantController;

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::post('login', [AdminAuthController::class, 'login']);
    Route::post('logout', [AdminAuthController::class, 'logout'])->middleware('admin.auth');
    Route::get('me', [AdminAuthController::class, 'me'])->middleware('admin.auth');
    Route::post('refresh', [AdminAuthController::class, 'refresh'])->middleware('admin.auth');
});

// Admin Protected Routes
Route::prefix('admin')->middleware(['admin.auth'])->group(function () {
    Route::apiResource('tenants', TenantController::class);
});