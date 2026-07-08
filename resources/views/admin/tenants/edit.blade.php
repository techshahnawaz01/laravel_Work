@extends('layouts.admin')

@section('title', 'Edit Tenant')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-6 max-w-2xl">
        <h3 class="text-xl font-semibold text-gray-800 mb-6">Edit Tenant</h3>

        <form action="{{ url('/admin/tenants/' . $tenant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Tenant Name</label>
                <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('name')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Slug</label>
                <input type="text" name="slug" value="{{ old('slug', $tenant->slug) }}" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-gray-500 text-sm mt-1">URL-friendly identifier (e.g., my-company)</p>
                @error('slug')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Schema Name</label>
                <input type="text" name="schema_name" value="{{ old('schema_name', $tenant->schema_name) }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <p class="text-gray-500 text-sm mt-1">PostgreSQL schema name for this tenant</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="active" {{ $tenant->status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ $tenant->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <p class="text-sm text-gray-500 mt-1">Inactive tenants cannot access the system</p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                    Update Tenant
                </button>
                <a href="{{ url('/admin/tenants') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection