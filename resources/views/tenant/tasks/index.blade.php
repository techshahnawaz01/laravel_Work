@extends('layouts.tenant')

@section('title', 'Tasks')

@section('content')
    <div class="surface p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Task board</p>
                <h3 class="mt-2 text-xl font-semibold">Your tenant tasks</h3>
            </div>
            <a href="{{ route('tenant.tasks.create', ['tenant' => $tenant->slug]) }}" class="btn-primary">Create Task</a>
        </div>

        <div class="table-wrap mt-6">
            <table class="table-ui">
                <thead>
                    <tr>
                        <th>Task</th>
                        <th>Status</th>
                        <th>Due date</th>
                        <th>Updated</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @forelse($tasks as $task)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $task->title }}</div>
                                <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ \Illuminate\Support\Str::limit($task->description, 70) ?: 'No description' }}</div>
                            </td>
                            <td>
                                <span class="badge {{ $task->status->value === 'completed' ? 'bg-teal-100 text-teal-800 dark:bg-teal-500/15 dark:text-teal-300' : ($task->status->value === 'in_progress' ? 'bg-sky-100 text-sky-800 dark:bg-sky-500/15 dark:text-sky-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-500/15 dark:text-amber-300') }}">
                                    {{ $task->status->label() }}
                                </span>
                            </td>
                            <td>{{ $task->due_date?->format('M d, Y') ?? 'No due date' }}</td>
                            <td>{{ $task->updated_at->diffForHumans() }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('tenant.tasks.edit', ['tenant' => $tenant->slug, 'task' => $task]) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form id="task-delete-{{ $task->id }}" action="{{ route('tenant.tasks.destroy', ['tenant' => $tenant->slug, 'task' => $task]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="submit"
                                            class="btn-danger px-3 py-2"
                                            data-confirm
                                            data-confirm-form="task-delete-{{ $task->id }}"
                                            data-confirm-title="Delete task?"
                                            data-confirm-message="The task will be removed from this tenant schema."
                                        >
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No tasks found for this tenant user.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </div>
@endsection
