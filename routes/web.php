<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Root URL - Smart Redirect
|--------------------------------------------------------------------------
| Redirects to appropriate panel based on authentication status
*/
Route::get('/', function () {
    if (auth()->guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| Route Files
|--------------------------------------------------------------------------
| Load route files for better organization
*/
require __DIR__ . '/admin.php';
require __DIR__ . '/tenant.php';