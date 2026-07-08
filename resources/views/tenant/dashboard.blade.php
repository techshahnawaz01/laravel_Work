@extends('layouts.tenant')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
        <section class="space-y-6">
            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Welcome back</p>
                <h3 class="mt-2 text-3xl font-semibold">{{ $user->name }}</h3>
                <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">You are operating inside the `{{ $tenant->schema_name }}` schema. Task data remains isolated from every other tenant.</p>
            </div>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Total tasks</p>
                    <p class="mt-4 text-4xl font-semibold">{{ $stats['total_tasks'] }}</p>
                </div>
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Pending</p>
                    <p class="mt-4 text-4xl font-semibold text-amber-600 dark:text-amber-300">{{ $stats['pending_tasks'] }}</p>
                </div>
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">In progress</p>
                    <p class="mt-4 text-4xl font-semibold text-sky-600 dark:text-sky-300">{{ $stats['in_progress_tasks'] }}</p>
                </div>
                <div class="surface p-6">
                    <p class="text-sm text-slate-500 dark:text-slate-400">Completed</p>
                    <p class="mt-4 text-4xl font-semibold text-teal-600 dark:text-teal-300">{{ $stats['completed_tasks'] }}</p>
                </div>
            </div>

            <div class="surface p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Recent tasks</p>
                        <h3 class="mt-2 text-xl font-semibold">Latest activity</h3>
                    </div>
                    <a href="{{ route('tenant.tasks.index', ['tenant' => $tenant->slug]) }}" class="btn-secondary">Manage tasks</a>
                </div>

                <div class="mt-6 space-y-3">
                    @forelse($recentTasks as $task)
                        <div class="surface-muted flex items-center justify-between p-4">
                            <div>
                                <p class="font-medium">{{ $task->title }}</p>
                                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $task->due_date?->format('M d, Y') ?? 'No due date' }}</p>
                            </div>
                            <span class="badge {{ $task->status->value === 'completed' ? 'bg-teal-100 text-teal-800 dark:bg-teal-500/15 dark:text-teal-300' : ($task->status->value === 'in_progress' ? 'bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300') }}">
                                {{ $task->status->label() }}
                            </span>
                        </div>
                    @empty
                        <div class="surface-muted p-5 text-sm text-slate-500 dark:text-slate-400">No tasks yet. Create the first task to start working inside this tenant schema.</div>
                    @endforelse
                </div>
            </div>
        </div>

        <section class="space-y-6">
            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Quick actions</p>
                <a href="{{ route('tenant.tasks.create', ['tenant' => $tenant->slug]) }}" class="btn-primary mt-5 w-full">Create Task</a>
            </div>
            <div class="surface p-6">
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Isolation guarantee</p>
                <ul class="mt-4 space-y-3 text-sm text-slate-600 dark:text-slate-300">
                    <li class="surface-muted p-4">`{{ $tenant->schema_name }}` is selected before task queries execute.</li>
                    <li class="surface-muted p-4">Only your own tasks are visible through authorization and query scoping.</li>
                    <li class="surface-muted p-4">Admin records remain stored in the `public` schema.</li>
                </ul>
            </div>
        </section>
    </div>
@endsection
