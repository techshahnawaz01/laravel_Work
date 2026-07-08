<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\LoginTenantRequest;
use App\Models\Tenant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        /** @var Tenant|null $tenant */
        $tenant = app()->bound('currentTenant') ? app('currentTenant') : null;

        if (!$tenant) {
            $tenant = Tenant::query()->where('status', 'active')->orderBy('name')->first();
        }

        return view('tenant.auth.login', [
            'tenant' => $tenant,
        ]);
    }

    public function login(LoginTenantRequest $request): RedirectResponse
    {
        if (Auth::guard('web')->attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();

            $tenant = app()->bound('currentTenant')
                ? app('currentTenant')
                : ($request->route('tenant')
                    ? Tenant::query()->where('slug', $request->route('tenant'))->first()
                    : Tenant::query()->where('status', 'active')->orderBy('name')->first());

            return redirect()->intended($tenant
                ? route('tenant.dashboard', ['tenant' => $tenant->slug])
                : route('admin.login'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials are invalid.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $tenant = $request->route('tenant');

        return redirect()->route($tenant ? 'tenant.login' : 'admin.login', $tenant ? ['tenant' => $tenant] : []);
    }
}
