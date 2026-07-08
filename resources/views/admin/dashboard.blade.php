@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
        <section class="space-y-6">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Total tenants</p>
                    <p class="mt-4 text-4xl font-semibold">{{ $stats['total'] }}</p>
                </div>
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Active</p>
                    <p class="mt-4 text-4xl font-semibold text-teal-600 dark:text-teal-300">{{ $stats['active'] }}</p>
                </div>
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Inactive</p>
                    <p class="mt-4 text-4xl font-semibold text-orange-600 dark:text-orange-300">{{ $stats['inactive'] }}</p>
                </div>
            </div>

            <div class="surface p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Recent tenants</p>
                        <h3 class="mt-2 text-xl font-semibold">Latest provisioned workspaces</h3>
                    </div>
                    <a href="{{ route('admin.tenants.index') }}" class="btn-secondary">View all</a>
                </div>

                <div class="table-wrap mt-6">
                    <table class="table-ui">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Schema</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                            @foreach($recentTenants as $tenant)
                                <tr>
                                    <td class="font-medium">{{ $tenant->name }}</td>
                                    <td>{{ $tenant->slug }}</td>
                                    <td class="font-mono text-xs">{{ $tenant->schema_name }}</td>
                                    <td>
                                        <span class="badge {{ $tenant->status->isActive() ? 'bg-teal-100 text-teal-800 dark:bg-teal-500/15 dark:text-teal-300' : 'bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-300' }}">
                                            {{ $tenant->status->label() }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section class="space-y-6">
            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Provisioning</p>
                <h3 class="mt-2 text-xl font-semibold">Create the next tenant schema</h3>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Provisioning creates the schema, runs tenant migrations, and seeds the first tenant user.</p>
                <a href="{{ route('admin.tenants.create') }}" class="btn-primary mt-6 w-full">Create Tenant</a>
            </div>

            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Status Overview</p>
                <h3 class="mt-2 text-xl font-semibold">Active vs Inactive</h3>
                <div class="mt-6 max-w-sm">
                    <canvas id="tenantStatusChart"></canvas>
                </div>
            </div>

            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tenant Creation</p>
                <h3 class="mt-2 text-xl font-semibold">New tenants over time</h3>
                <div class="mt-6">
                    <canvas id="tenantTimelineChart"></canvas>
                </div>
            </div>

            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Operations</p>
                <ul class="mt-4 space-y-4 text-sm text-slate-600 dark:text-slate-300">
                    <li class="surface-muted p-4">Public schema stores only tenant metadata and super admin accounts.</li>
                    <li class="surface-muted p-4">Each tenant schema contains isolated `users` and `tasks` tables.</li>
                    <li class="surface-muted p-4">Schema switching runs before tenant auth and route model binding.</li>
                </ul>
            </div>
        </section>
    </div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const statusCtx = document.getElementById('tenantStatusChart');
    if (statusCtx) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ["Active", "Inactive"],
                datasets: [{
                    data: [0, 0],
                    backgroundColor: ['#0d9488', '#f97316'],
                }]
            },
            options: { maintainAspectRatio: false }
        });
    }

    const timelineCtx = document.getElementById('tenantTimelineChart');
    if (timelineCtx) {
        new Chart(timelineCtx, {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar"],
                datasets: [{
                    label: 'Tenants created',
                    data: [1, 1, 2],
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.1)',
                    tension: 0.4,
                    fill: true,
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
            }
        });
    }
});
</script>
@endpush
@endsection
