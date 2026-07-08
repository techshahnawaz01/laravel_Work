<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>
<body>
    <div class="shell">
        <aside class="shell-sidebar">
            <div class="mb-10">
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-teal-300">Super Admin</p>
                <h1 class="mt-3 text-2xl font-semibold">{{ config('app.name') }}</h1>
                <p class="mt-2 text-sm text-slate-400">Schema-isolated SaaS control center.</p>
            </div>

            <nav class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-link-active' : '' }}">
                    <span>@include('partials.icons.chart')</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.tenants.index') }}" class="nav-link {{ request()->routeIs('admin.tenants.*') ? 'nav-link-active' : '' }}">
                    <span>@include('partials.icons.building')</span>
                    Tenants
                </a>
            </nav>
            <form action="{{ route('admin.logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="btn-secondary w-full">
                    <span>@include('partials.icons.logout')</span>
                    Sign Out
                </button>
            </form>
        </aside>

        <main class="shell-main">
            <header class="surface mb-6 flex flex-col gap-4 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Admin workspace</p>
                    <h2 class="mt-2 text-2xl font-semibold">@yield('title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-3">
                    <button type="button" data-theme-toggle class="btn-secondary">
                        <span>@include('partials.icons.moon')</span>
                        Theme
                    </button>
                    <div class="surface-muted flex items-center gap-3 px-4 py-3">
                        <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-teal-700 text-sm font-semibold text-white">
                            {{ strtoupper(substr(auth()->guard('admin')->user()?->name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold">{{ auth()->guard('admin')->user()?->name }}</p>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Platform owner</p>
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
