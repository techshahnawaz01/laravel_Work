<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Tenant Dashboard') · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @php
        $currentTenant = app()->bound('currentTenant') ? app('currentTenant') : null;
    @endphp
    <div class="shell">
        <aside class="shell-sidebar">
            <div class="mb-10">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-orange-300">Tenant Portal</p>
                <h1 class="mt-3 text-2xl font-semibold">{{ $currentTenant?->name ?? 'Tenant Workspace' }}</h1>
                <p class="mt-2 text-sm text-slate-400">Schema: {{ $currentTenant?->schema_name ?? 'public' }}</p>
            </div>

            <nav class="space-y-2">
                @if($currentTenant)
                    <a href="{{ route('tenant.dashboard', ['tenant' => request()->route('tenant')]) }}" class="nav-link {{ request()->routeIs('tenant.dashboard') ? 'nav-link-active' : '' }}">
                        <span>@include('partials.icons.chart')</span>
                        Dashboard
                    </a>
                    <a href="{{ route('tenant.tasks.index', ['tenant' => request()->route('tenant')]) }}" class="nav-link {{ request()->routeIs('tenant.tasks.*') ? 'nav-link-active' : '' }}">
                        <span>@include('partials.icons.tasks')</span>
                        Tasks
                    </a>
                @else
                    <div class="surface-muted p-4 text-sm text-slate-300">
                        Select a tenant login URL to continue.
                    </div>
                @endif
            </nav>

            <div class="mt-10 surface-muted p-4 text-sm text-slate-300">
                <p class="font-semibold text-white">Tenant Login</p>
                <p class="mt-2">`owner@acme.test`</p>
                <p>`password`</p>
            </div>

            @if($currentTenant && auth()->check())
                <form action="{{ route('tenant.logout', ['tenant' => request()->route('tenant')]) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="btn-secondary w-full">
                        <span>@include('partials.icons.logout')</span>
                        Sign Out
                    </button>
                </form>
            @endif
        </aside>

        <main class="shell-main">
            <header class="surface mb-6 flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tenant workspace</p>
                    <h2 class="mt-2 text-2xl font-semibold">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" data-theme-toggle class="btn-secondary">
                        <span>@include('partials.icons.moon')</span>
                        Theme
                    </button>
                    <div class="surface-muted flex items-center gap-3 px-4 py-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-orange-600 text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->user()?->name ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold">{{ auth()->user()?->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $currentTenant?->slug ?? 'guest' }}</p>
                        </div>
                    </div>
                </div>
            </header>

            @include('partials.feedback')

            @yield('content')
        </main>
    </div>

    @include('partials.confirm-modal')
</body>
</html>
