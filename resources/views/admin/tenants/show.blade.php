@extends('layouts.admin')

@section('title', 'Tenant Details')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">Tenant Details</h3>
            <div class="flex gap-3">
                <a href="{{ url('/admin/tenants/' . $tenant->id . '/edit') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                    Edit
                </a>
                <a href="{{ url('/admin/tenants') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                    Back to List
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Name</label>
                <p class="text-gray-800 font-medium">{{ $tenant->name }}</p>
            </div>

            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Slug</label>
                <p class="text-gray-800 font-medium">{{ $tenant->slug }}</p>
            </div>

            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Schema Name</label>
                <p class="text-gray-800 font-mono text-sm">{{ $tenant->schema_name }}</p>
            </div>

            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Status</label>
                <span class="px-3 py-1 rounded-full text-sm font-medium {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($tenant->status) }}
                </span>
            </div>

            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Created At</label>
                <p class="text-gray-800">{{ $tenant->created_at->format('M d, Y H:i A') }}</p>
            </div>

            <div>
                <label class="block text-gray-500 text-sm font-medium mb-1">Updated At</label>
                <p class="text-gray-800">{{ $tenant->updated_at->format('M d, Y H:i A') }}</p>
            </div>
        </div>

        <div class="mt-8 pt-6 border-t border-gray-200">
            <h4 class="text-lg font-semibold text-gray-800 mb-4">Actions</h4>
            <div class="flex gap-3">
                @if($tenant->status === 'active')
                    <form action="{{ url('/admin/tenants/' . $tenant->id . '/deactivate') }}" method="POST" onsubmit="return confirm('Are you sure you want to deactivate this tenant?')">
                        @csrf
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-lg transition">
                            Deactivate Tenant
                        </button>
                    </form>
                @else
                    <form action="{{ url('/admin/tenants/' . $tenant->id . '/activate') }}" method="POST" onsubmit="return confirm('Are you sure you want to activate this tenant?')">
                        @csrf
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition">
                            Activate Tenant
                        </button>
                    </form>
                @endif

                <form action="{{ url('/admin/tenants/' . $tenant->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition">
                        Delete Tenant
                    </button>
                </form>

                <form action="{{ url('/admin/tenants/' . $tenant->id . '/initialize') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg transition">
                        Initialize Tenant
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection