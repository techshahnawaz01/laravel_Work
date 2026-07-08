<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;

class TaskService
{
    public function paginateForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return $this->forUser($user)
            ->latest()
            ->paginate($perPage);
    }

    public function create(User $user, array $data): Task
    {
        $ownershipColumn = $this->ownershipColumn();

        $task = new Task($data);
        $task->{$ownershipColumn} = $user->id;
        $task->save();

        return $task;
    }

    public function update(Task $task, array $data): Task
    {
        $task->update($data);
        return $task->fresh();
    }

    public function delete(Task $task): void
    {
        $task->delete();
    }

    public function statsForUser(User $user): array
    {
        return [
            'total_tasks' => $this->forUser($user)->count(),
            'pending_tasks' => $this->forUser($user)->where('status', TaskStatus::Pending)->count(),
            'in_progress_tasks' => $this->forUser($user)->where('status', TaskStatus::InProgress)->count(),
            'completed_tasks' => $this->forUser($user)->where('status', TaskStatus::Completed)->count(),
        ];
    }

    public function recentForUser(User $user, int $limit = 5)
    {
        return $this->forUser($user)->latest()->limit($limit)->get();
    }

    private function forUser(User $user): Builder
    {
        $column = $this->ownershipColumn();

        return Task::query()->where($column, $user->id);
    }

    private function ownershipColumn(): string
    {
        if (Schema::hasColumn('tasks', 'user_id')) {
            return 'user_id';
        }

        if (Schema::hasColumn('tasks', 'assigned_to')) {
            return 'assigned_to';
        }

        return 'created_by';
    }
}
