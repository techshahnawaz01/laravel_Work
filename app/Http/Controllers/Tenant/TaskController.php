<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::guard('web')->user();
        $tasks = Task::where('created_by', $user->id)
            ->orWhere('assigned_to', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('tenant.tasks.index', compact('tasks', 'user'));
    }

    public function create()
    {
        return view('tenant.tasks.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);
        $validated['created_by'] = Auth::guard('web')->id();
        $validated['assigned_to'] = Auth::guard('web')->id();
        Task::create($validated);
        return redirect()->route('tenant.tasks.index')->with('success', 'Task created');
    }

    public function show(Task $task)
    {
        $user = Auth::guard('web')->user();
        if ($task->created_by !== $user->id && $task->assigned_to !== $user->id) {
            abort(403);
        }
        return view('tenant.tasks.show', compact('task', 'user'));
    }

    public function edit(Task $task)
    {
        $user = Auth::guard('web')->user();
        if ($task->created_by !== $user->id && $task->assigned_to !== $user->id) {
            abort(403);
        }
        return view('tenant.tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if ($task->created_by !== $user->id && $task->assigned_to !== $user->id) {
            abort(403);
        }
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pending,in_progress,completed',
            'due_date' => 'nullable|date',
        ]);
        $task->update($validated);
        return redirect()->route('tenant.tasks.index')->with('success', 'Task updated');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $user = Auth::guard('web')->user();
        if ($task->created_by !== $user->id && $task->assigned_to !== $user->id) {
            abort(403);
        }
        $task->delete();
        return redirect()->route('tenant.tasks.index')->with('success', 'Task deleted');
    }
}