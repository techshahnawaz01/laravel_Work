@extends('layouts.tenant')

@section('title', 'Dashboard')

@section('content')
<div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">

    {{-- Left Section --}}
    <section class="space-y-6">

        <div class="surface p-6">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                Welcome back
            </p>

            <h3 class="mt-2 text-3xl font-semibold">
                {{ $user->name }}
            </h3>

            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">
                Work inside <strong>{{ $tenant->name }}</strong> without touching any other tenant data.
            </p>
        </div>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
            <div class="surface p-6">
                <p class="text-sm text-slate-500 dark:text-slate-400">Total tasks</p>
                <p class="mt-4 text-4xl font-semibold">{{ $stats['total_tasks'] }}</p>
            </div>

            <div class="surface p-6">
                <p class="text-sm text-slate-500 dark:text-slate-400">Pending</p>
                <p class="mt-4 text-4xl font-semibold text-amber-600 dark:text-amber-300">
                    {{ $stats['pending_tasks'] }}
                </p>
            </div>

            <div class="surface p-6">
                <p class="text-sm text-slate-500 dark:text-slate-400">In Progress</p>
                <p class="mt-4 text-4xl font-semibold text-sky-600 dark:text-sky-300">
                    {{ $stats['in_progress_tasks'] }}
                </p>
            </div>

            <div class="surface p-6">
                <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
                <p class="mt-4 text-4xl font-semibold text-teal-600 dark:text-teal-300">
                    {{ $stats['completed_tasks'] }}
                </p>
            </div>
        </div>

        <div class="surface p-6">

            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                        Recent Tasks
                    </p>

                    <h3 class="mt-2 text-xl font-semibold">
                        Latest Activity
                    </h3>
                </div>

                <a href="{{ route('tenant.tasks.index', ['tenant' => $tenant->slug]) }}"
                   class="btn-secondary">
                    Manage Tasks
                </a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse($recentTasks as $task)

                    <div class="surface-muted flex items-center justify-between p-4">

                        <div>
                            <p class="font-medium">{{ $task->title }}</p>

                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                {{ $task->due_date?->format('M d, Y') ?? 'No due date' }}
                            </p>
                        </div>

                        <span class="badge
                            {{ $task->status->value === 'completed'
                                ? 'bg-teal-100 text-teal-800 dark:bg-teal-500/15 dark:text-teal-300'
                                : ($task->status->value === 'in_progress'
                                    ? 'bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300'
                                    : 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300')
                            }}">
                            {{ $task->status->label() }}
                        </span>

                    </div>

                @empty

                    <div class="surface-muted p-5 text-sm text-slate-500 dark:text-slate-400">
                        No tasks yet. Create your first task to get started.
                    </div>

                @endforelse
            </div>

        </div>

    </section>

    {{-- Right Section --}}
    <section class="space-y-6">

        <div class="surface p-6">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                Task Overview
            </p>

            <h3 class="mt-2 text-xl font-semibold">
                Status Breakdown
            </h3>

            <div class="mt-6 h-72">
                <canvas id="taskStatusChart"></canvas>
            </div>
        </div>

        <div class="surface p-6">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">
                Isolation Guarantee
            </p>

            <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                <li class="surface-muted p-4">
                    <strong>{{ $tenant->schema_name }}</strong> is selected before task queries execute.
                </li>

                <li class="surface-muted p-4">
                    Only your own tasks are visible through authorization and query scoping.
                </li>

                <li class="surface-muted p-4">
                    Admin records remain stored in the <strong>public</strong> schema.
                </li>
            </ul>
        </div>

    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    const ctx = document.getElementById('taskStatusChart');

    if (!ctx) return;

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'In Progress', 'Completed'],
            datasets: [{
                data: [
                    {{ $stats['pending_tasks'] }},
                    {{ $stats['in_progress_tasks'] }},
                    {{ $stats['completed_tasks'] }}
                ],
                backgroundColor: [
                    '#f59e0b',
                    '#0ea5e9',
                    '#0d9488'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

});
</script>
@endpush