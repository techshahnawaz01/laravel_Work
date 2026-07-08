@extends('layouts.auth')

@section('title', 'Admin Login')
@section('eyebrow', 'Platform Control')
@section('headline', 'Manage every tenant from a single operating console.')
@section('subheadline', 'Provision new PostgreSQL schemas, monitor tenant status, and keep the SaaS platform clean and isolated.')

@section('content')
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-teal-600 dark:text-teal-300">Admin Login</p>
        <h2 class="mt-4 text-3xl font-semibold">Access the control plane</h2>
        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Use the seeded super admin account to manage tenant provisioning.</p>
    </div>

    <div class="surface-muted mt-8 p-4 text-sm">
        <p class="font-semibold">Demo credentials</p>
        <p class="mt-2">Email: `admin@example.com`</p>
        <p>Password: `password`</p>
    </div>

    <form action="{{ route('admin.login') }}" method="POST" class="mt-8 space-y-5">
        @csrf
        <div>
            <label for="email" class="text-sm font-medium">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-field" required autofocus>
        </div>
        <div>
            <label for="password" class="text-sm font-medium">Password</label>
            <input id="password" type="password" name="password" class="form-field" required>
        </div>
        <button type="submit" class="btn-primary w-full" data-loading-button data-loading-text="Signing in...">
            Sign In
        </button>
    </form>
@endsection
