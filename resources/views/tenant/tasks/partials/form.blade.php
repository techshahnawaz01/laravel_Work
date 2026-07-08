<div class="mx-auto max-w-4xl space-y-6">
    <div class="surface p-6">
        <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Task editor</p>
        <h3 class="mt-2 text-2xl font-semibold">{{ $task ? 'Update task details' : 'Create a new task' }}</h3>
        <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">Tasks stay scoped to your account within the current tenant schema.</p>
    </div>

    <form action="{{ $action }}" method="POST" class="surface p-6">
        @csrf
        @if($method !== 'POST')
            @method($method)
        @endif

        <div class="space-y-6">
            <div>
                <label for="title" class="text-sm font-medium">Title</label>
                <input id="title" name="title" value="{{ old('title', $task?->title) }}" class="form-field" required>
            </div>

            <div>
                <label for="description" class="text-sm font-medium">Description</label>
                <textarea id="description" name="description" rows="5" class="form-field">{{ old('description', $task?->description) }}</textarea>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="status" class="text-sm font-medium">Status</label>
                    <select id="status" name="status" class="form-field" required>
                        @foreach(\App\Enums\TaskStatus::cases() as $status)
                            <option value="{{ $status->value }}" @selected(old('status', $task?->status?->value ?? 'pending') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="due_date" class="text-sm font-medium">Due date</label>
                    <input id="due_date" type="date" name="due_date" value="{{ old('due_date', $task?->due_date?->format('Y-m-d')) }}" class="form-field">
                </div>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('tenant.tasks.index', ['tenant' => $tenant->slug]) }}" class="btn-secondary">Cancel</a>
            <button type="submit" class="btn-primary" data-loading-button data-loading-text="Saving...">{{ $submitLabel }}</button>
        </div>
    </form>
</div>
