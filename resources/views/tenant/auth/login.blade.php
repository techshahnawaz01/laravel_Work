@extends('layouts.auth')

@section('title', 'Tenant Login')
@section('eyebrow', 'Tenant Access')
@section('headline', 'Work inside ' . $tenant->name . ' without touching any other tenant data.')
@section('subheadline', 'The middleware switches PostgreSQL schemas before authentication and task queries are resolved.')

@section('content')
    <div>
        <p class="text-sm font-semibold uppercase tracking-[0.28em] text-orange-600 dark:text-orange-300">Tenant Login</p>
        <h2 class="mt-4 text-3xl font-semibold">{{ $tenant->name }}</h2>
        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Slug: `{{ $tenant->slug }}` · Schema: `{{ $tenant->schema_name }}`</p>
    </div>


    <form action="{{ route('tenant.login', ['tenant' => $tenant->slug]) }}" method="POST" class="mt-8 space-y-5">
        @csrf
        <div>
            <label for="email" class="text-sm font-medium">Email address</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-field" required autofocus>
        </div>
        <div>
            <label for="password" class="text-sm font-medium">Password</label>
            <input id="password" type="password" name="password" class="form-field" required>
        </div>
        <label class="flex items-center gap-3 text-sm text-slate-500 dark:text-slate-400">
            <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300">
            Keep me signed in on this browser
        </label>
        <button type="submit" class="btn-primary w-full" data-loading-button data-loading-text="Signing in...">
            Enter Workspace
        </button>
    </form>
@endsection
