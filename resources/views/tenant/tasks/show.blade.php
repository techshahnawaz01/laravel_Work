@extends('layouts.tenant')

@section('title', 'Task Details')

@section('content')
    <div class="py-8">
        <div class="max-w-4xl">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Task Details</h1>
                <div class="flex gap-2">
                    <a href="{{ route('tenant.tasks.edit', $task->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                        Edit
                    </a>
                    <a href="{{ route('tenant.tasks.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">
                        Back
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-sm font-medium mb-1">Title</label>
                        <p class="text-lg font-semibold text-gray-800">{{ $task->title }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Status</label>
                        <p>
                            @switch($task->status)
                                @case('pending')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @break
                                @case('in_progress')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                    @break
                                @case('completed')
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">Completed</span>
                                    @break
                            @endswitch
                        </p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Due Date</label>
                        <p class="text-gray-800">{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No due date' }}</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-gray-500 text-sm font-medium mb-1">Description</label>
                        <p class="text-gray-800 whitespace-pre-wrap">{{ $task->description ?? 'No description' }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Created By</label>
                        <p class="text-gray-800">{{ $task->created_by === $user->id ? 'You' : 'User #' . $task->created_by }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Assigned To</label>
                        <p class="text-gray-800">{{ $task->assigned_to === $user->id ? 'You' : 'User #' . $task->assigned_to }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Created At</label>
                        <p class="text-gray-800">{{ $task->created_at->format('M d, Y h:i A') }}</p>
                    </div>

                    <div>
                        <label class="block text-gray-500 text-sm font-medium mb-1">Last Updated</label>
                        <p class="text-gray-800">{{ $task->updated_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <form action="{{ route('tenant.tasks.destroy', $task->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition" onclick="return confirm('Are you sure you want to delete this task?')">
                            Delete Task
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection