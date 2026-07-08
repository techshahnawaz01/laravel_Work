@extends('layouts.admin')

@section('title', 'Tenants')

@section('content')
    <div class="surface p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Tenant registry</p>
                <h3 class="mt-2 text-xl font-semibold">Provisioned workspaces</h3>
            </div>
            <a href="{{ route('admin.tenants.create') }}" class="btn-primary">Create Tenant</a>
        </div>

        <div class="table-wrap mt-6">
            <table class="table-ui">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Schema</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200/70 dark:divide-white/10">
                    @forelse($tenants as $tenant)
                        <tr>
                            <td class="font-medium">{{ $tenant->name }}</td>
                            <td>{{ $tenant->slug }}</td>
                            <td class="font-mono text-xs">{{ $tenant->schema_name }}</td>
                            <td>
                                <span class="badge {{ $tenant->status->isActive() ? 'bg-teal-100 text-teal-800 dark:bg-teal-500/15 dark:text-teal-300' : 'bg-orange-100 text-orange-800 dark:bg-orange-500/15 dark:text-orange-300' }}">
                                    {{ $tenant->status->label() }}
                                </span>
                            </td>
                            <td>{{ $tenant->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.tenants.edit', $tenant->id) }}" class="btn-secondary px-3 py-2">Edit</a>
                                    <form id="tenant-toggle-{{ $tenant->id }}" action="{{ $tenant->status->isActive() ? route('admin.tenants.deactivate', $tenant->id) : route('admin.tenants.activate', $tenant->id) }}" method="POST">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="{{ $tenant->status->isActive() ? 'btn-danger' : 'btn-primary' }} px-3 py-2"
                                            data-confirm
                                            data-confirm-form="tenant-toggle-{{ $tenant->id }}"
                                            data-confirm-title="{{ $tenant->status->isActive() ? 'Deactivate tenant?' : 'Activate tenant?' }}"
                                            data-confirm-message="This changes access to the tenant workspace without touching other tenant schemas."
                                        >
                                            {{ $tenant->status->isActive() ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-slate-500 dark:text-slate-400">No tenants created yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $tenants->links() }}
        </div>
    </div>
@endsection
