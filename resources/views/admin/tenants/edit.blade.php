@extends('layouts.admin')

@section('title', 'Edit Tenant')

@section('content')
<div class="mx-auto max-w-4xl space-y-6">
    <div class="surface p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tenant settings</p>
                <h3 class="mt-2 text-2xl font-semibold">{{ $tenant->name }}</h3>
            </div>
            <div class="surface-muted px-4 py-3 text-sm">
                <p>Schema: <span class="font-mono">{{ $tenant->schema_name }}</span></p>
                <p class="mt-1">
                    Login path:
                    <span class="font-mono">{{ url('tenant/' . $tenant->slug . '/login') }}</span>

                </p>
            </div>
        </div>
    </div>

    <form action="{{ route('admin.tenants.update', $tenant->id) }}" method="POST" class="surface p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-6 md:grid-cols-2">
            <div>
                <label for="name" class="text-sm font-medium">Tenant name</label>
                <input id="name" name="name" value="{{ old('name', $tenant->name) }}" class="form-field" required>
            </div>
            <div>
                <label for="slug" class="text-sm font-medium">Tenant slug</label>
                <input id="slug" name="slug" value="{{ old('slug', $tenant->slug) }}" class="form-field" required>
            </div>
            <div>
                <label for="status" class="text-sm font-medium">Status</label>
                <select id="status" name="status" class="form-field" required>
                    @foreach($statuses as $status)
                    <option value="{{ $status->value }}" @selected(old('status', $tenant->status->value) === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('admin.tenants.index') }}" class="btn-secondary">Back</a>
            <button type="submit" class="btn-primary" data-loading-button data-loading-text="Saving...">Save Changes</button>
        </div>
    </form>
</div>
@endsection