<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TaskRepositoryInterface;
use App\Contracts\TaskServiceInterface;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskService implements TaskServiceInterface
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository
    ) {}

    /**
     * Get all tasks.
     */
    public function getAll(int $tenantId): Collection
    {
        return $this->taskRepository->all();
    }

    /**
     * Find a task by ID.
     */
    public function getById(int $id): Task
    {
        $task = $this->taskRepository->findById((string) $id);

        if (!$task) {
            throw new \InvalidArgumentException("Task not found: {$id}");
        }

        return $task;
    }

    /**
     * Get tasks for a specific tenant.
     */
    public function getByTenant(int $tenantId): Collection
    {
        return Task::where('tenant_id', $tenantId)->get();
    }

    /**
     * Get tasks by status for a tenant.
     */
    public function getByStatus(int $tenantId, TaskStatus $status): Collection
    {
        return Task::where('tenant_id', $tenantId)
            ->where('status', $status)
            ->get();
    }

    /**
     * Get tasks by priority for a tenant.
     */
    public function getByPriority(int $tenantId, TaskPriority $priority): Collection
    {
        return Task::where('tenant_id', $tenantId)
            ->where('priority', $priority)
            ->get();
    }

    /**
     * Create a new task.
     */
    public function create(CreateTaskDTO $dto): Task
    {
        return $this->taskRepository->create($dto);
    }

    /**
     * Update an existing task.
     */
    public function update(int $id, UpdateTaskDTO $dto): Task
    {
        $task = $this->taskRepository->findById((string) $id);

        if (!$task) {
            throw new \InvalidArgumentException("Task not found: {$id}");
        }

        $this->taskRepository->update($dto);

        return $task->fresh();
    }

    /**
     * Delete a task.
     */
    public function delete(int $id): bool
    {
        return $this->taskRepository->delete((string) $id);
    }

    /**
     * Complete a task.
     */
    public function complete(int $id): Task
    {
        $task = $this->getById($id);

        $task->update(['status' => TaskStatus::Completed]);

        return $task->fresh();
    }

    /**
     * Cancel a task.
     */
    public function cancel(int $id): Task
    {
        $task = $this->getById($id);

        $task->update(['status' => TaskStatus::Cancelled]);

        return $task->fresh();
    }

    /**
     * Get overdue tasks for a tenant.
     */
    public function getOverdueTasks(int $tenantId): Collection
    {
        return Task::where('tenant_id', $tenantId)
            ->where('due_date', '<', now())
            ->whereNotIn('status', [TaskStatus::Completed, TaskStatus::Cancelled])
            ->get();
    }

    /**
     * Get task count for a tenant.
     */
    public function getTaskCount(int $tenantId): int
    {
        return Task::where('tenant_id', $tenantId)->count();
    }

    /**
     * Find task by tenant and ID.
     */
    public function findByTenantAndId(int $tenantId, int $id): ?Task
    {
        return Task::where('tenant_id', $tenantId)
            ->where('id', $id)
            ->first();
    }
}