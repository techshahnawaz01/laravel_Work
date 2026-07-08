<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tenant\StoreTaskRequest;
use App\Http\Requests\Tenant\UpdateTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(): View
    {
        $user = Auth::guard('web')->user();

        return view('tenant.tasks.index', [
            'tasks' => $this->taskService->paginateForUser($user),
            'user' => $user,
            'tenant' => app('currentTenant'),
        ]);
    }

    public function create(): View
    {
        return view('tenant.tasks.create', [
            'tenant' => app('currentTenant'),
        ]);
    }

    public function store(StoreTaskRequest $request): RedirectResponse
    {
        $this->taskService->create(Auth::guard('web')->user(), $request->validated());

        return redirect()
            ->route('tenant.tasks.index', ['tenant' => $request->route('tenant')])
            ->with('success', 'Task created successfully.');
    }

    public function edit(string $tenant, Task $task): View
    {
        $this->authorize('update', $task);

        return view('tenant.tasks.edit', [
            'task' => $task,
            'tenant' => app('currentTenant'),
        ]);
    }

    public function update(UpdateTaskRequest $request, string $tenant, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);
        $this->taskService->update($task, $request->validated());

        return redirect()
            ->route('tenant.tasks.index', ['tenant' => $request->route('tenant')])
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(string $tenant, Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);
        $this->taskService->delete($task);

        return redirect()
            ->route('tenant.tasks.index', ['tenant' => $tenant])
            ->with('success', 'Task deleted successfully.');
    }
}
