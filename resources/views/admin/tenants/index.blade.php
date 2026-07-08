@extends('layouts.admin')

@section('title', 'Tenants')

@section('content')
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-semibold text-gray-800">All Tenants</h3>
            <a href="{{ url('/admin/tenants/create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                + Add Tenant
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Name</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Slug</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Schema</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Created</th>
                        <th class="text-left py-3 px-4 font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenants as $tenant)
                        <tr class="border-b border-gray-100 hover:bg-gray-50 transition">
                            <td class="py-3 px-4 font-medium">{{ $tenant->name }}</td>
                            <td class="py-3 px-4">{{ $tenant->slug }}</td>
                            <td class="py-3 px-4 font-mono text-sm">{{ $tenant->schema_name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-medium {{ $tenant->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($tenant->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $tenant->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <a href="{{ url('/admin/tenants/' . $tenant->id) }}" class="text-blue-600 hover:text-blue-800 mr-2">View</a>
                                <a href="{{ url('/admin/tenants/' . $tenant->id . '/edit') }}" class="text-green-600 hover:text-green-800 mr-2">Edit</a>
                                
                                @if($tenant->status === 'active')
                                    <form action="{{ url('/admin/tenants/' . $tenant->id . '/deactivate') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-orange-600 hover:text-orange-800 mr-2">Deactivate</button>
                                    </form>
                                @else
                                    <form action="{{ url('/admin/tenants/' . $tenant->id . '/activate') }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-green-600 hover:text-green-800 mr-2">Activate</button>
                                    </form>
                                @endif
                                
                                <form action="{{ url('/admin/tenants/' . $tenant->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-gray-500">No tenants found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection