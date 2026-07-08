@extends('layouts.tenant')

@section('title', 'Page Not Found')

@section('content')
<div class="py-8">
    <div class="max-w-2xl mx-auto text-center">
        <div class="mb-6">
            <svg class="w-32 h-32 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        
        <h1 class="text-6xl font-bold text-gray-800 mb-4">404</h1>
        <h2 class="text-2xl font-semibold text-gray-700 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-8">The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
        
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