<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TaskRepositoryInterface;
use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    /**
     * Create a new TaskRepository instance.
     */
    public function __construct(Task $task)
    {
        parent::__construct($task);
    }

    /**
     * Find all tasks for a tenant.
     */
    public function findByTenant(int $tenantId): Collection
    {
        return $this->model->where('tenant_id', $tenantId)->get();
    }

    /**
     * Find tasks by status for a tenant.
     */
    public function findByStatus(int $tenantId, TaskStatus $status): Collection
    {
        return $this->model->where('tenant_id', $tenantId)
            ->where('status', $status)
            ->get();
    }

    /**
     * Find tasks by priority for a tenant.
     */
    public function findByPriority(int $tenantId, TaskPriority $priority): Collection
    {
        return $this->model->where('tenant_id', $tenantId)
            ->where('priority', $priority)
            ->get();
    }

    /**
     * Create a new task.
     */
    public function create(CreateTaskDTO $dto): Model
    {
        return $this->model->create($dto->toArray());
    }

    /**
     * Update an existing task.
     */
    public function update(int $id, UpdateTaskDTO $dto): Model
    {
        $this->model->where('id', $id)->update($dto->toArray());

        return $this->model->find($id);
    }

    /**
     * Delete a task by ID.
     */
    public function delete(int $id): bool
    {
        $record = $this->model->find($id);

        if ($record === null) {
            return false;
        }

        return (bool) $record->delete();
    }

    /**
     * Mark task as completed.
     */
    public function markAsCompleted(int $id): Model
    {
        $this->model->where('id', $id)->update(['status' => TaskStatus::Completed]);

        return $this->model->find($id);
    }

    /**
     * Mark task as cancelled.
     */
    public function markAsCancelled(int $id): Model
    {
        $this->model->where('id', $id)->update(['status' => TaskStatus::Cancelled]);

        return $this->model->find($id);
    }

    /**
     * Count tasks for a tenant.
     */
    public function countByTenant(int $tenantId): int
    {
        return $this->model->where('tenant_id', $tenantId)->count();
    }

    /**
     * Get overdue tasks for a tenant.
     */
    public function getOverdue(int $tenantId): Collection
    {
        return $this->model->where('tenant_id', $tenantId)
            ->where('due_date', '<', now())
            ->whereNotIn('status', [TaskStatus::Completed, TaskStatus::Cancelled])
            ->get();
    }
}