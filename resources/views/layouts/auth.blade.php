<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="grid w-full max-w-6xl gap-8 lg:grid-cols-[1.1fr_0.9fr]">
        <section class="surface hidden overflow-hidden p-10 lg:block">
            <div class="max-w-xl">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-teal-600 dark:text-teal-300">@yield('eyebrow')</p>
                <h1 class="mt-6 text-5xl font-semibold leading-tight">@yield('headline')</h1>
                <p class="mt-6 text-lg text-slate-600 dark:text-slate-300">@yield('subheadline')</p>
            </div>

            <div class="mt-12 grid gap-4 sm:grid-cols-2">
                <div class="surface-muted p-5">
                    <p class="text-sm font-semibold">Schema isolation</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Every tenant operates on its own PostgreSQL schema.</p>
                </div>
                <div class="surface-muted p-5">
                    <p class="text-sm font-semibold">Operational clarity</p>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Admin and tenant flows stay separate and predictable.</p>
                </div>
            </div>
        </section>

        <section class="surface p-6 sm:p-8 lg:p-10">
            @include('partials.feedback')
            @yield('content')
        </section>
    </div>
</body>
</html>
