@extends('layouts.tenant')

@section('title', 'Access Denied')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mb-6">
            <svg class="w-32 h-32 mx-auto text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-800 mb-4">403</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Access Denied</h2>
        <p class="text-gray-600 mb-8">You don't have permission to access this resource.</p>
        
        <div class="flex gap-4 justify-center">
            <a href="{{ url('/dashboard') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg transition">
                Go to Dashboard
            </a>
            <a href="javascript:history.back()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg transition">
                Go Back
            </a>
        </div>
    </div>
</div>
@endsection