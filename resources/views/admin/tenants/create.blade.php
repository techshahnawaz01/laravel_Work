@extends('layouts.admin')

@section('title', 'Create Tenant')

@section('content')
    <div class="mx-auto max-w-4xl space-y-6">
        <div class="surface p-6">
            <p class="text-sm uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400">Provision new workspace</p>
            <h3 class="mt-2 text-2xl font-semibold">Create tenant and seed the first account</h3>
            <p class="mt-3 text-sm text-slate-500 dark:text-slate-400">The provisioning flow creates the tenant record, PostgreSQL schema, tenant tables, and owner credentials in one transaction-backed operation.</p>
        </div>

        <form action="{{ route('admin.tenants.store') }}" method="POST" class="surface p-6">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label for="name" class="text-sm font-medium">Tenant name</label>
                    <input id="name" name="name" value="{{ old('name') }}" class="form-field" required>
                </div>
                <div>
                    <label for="slug" class="text-sm font-medium">Tenant slug</label>
                    <input id="slug" name="slug" value="{{ old('slug') }}" class="form-field" required>
                </div>
                <div>
                    <label for="owner_name" class="text-sm font-medium">Owner name</label>
                    <input id="owner_name" name="owner_name" value="{{ old('owner_name') }}" class="form-field" required>
                </div>
                <div>
                    <label for="owner_email" class="text-sm font-medium">Owner email</label>
                    <input id="owner_email" type="email" name="owner_email" value="{{ old('owner_email') }}" class="form-field" required>
                </div>
                <div>
                    <label for="owner_password" class="text-sm font-medium">Owner password</label>
                    <input id="owner_password" type="password" name="owner_password" class="form-field" required>
                </div>
                <div>
                    <label for="status" class="text-sm font-medium">Initial status</label>
                    <select id="status" name="status" class="form-field" required>
                        @foreach($statuses as $status)
                            <option value="{{ $status->value }}" @selected(old('status', 'active') === $status->value)>{{ $status->label() }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <a href="{{ route('admin.tenants.index') }}" class="btn-secondary">Cancel</a>
                <button type="submit" class="btn-primary" data-loading-button data-loading-text="Provisioning...">Provision Tenant</button>
            </div>
        </form>
    </div>
@endsection
