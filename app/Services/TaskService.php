<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskService
{
    public function paginateForUser(User $user, int $perPage = 10): LengthAwarePaginator
    {
        return Task::query()
            ->where('user_id', $user->id)
            ->latest()
            ->paginate($perPage);
    }

    public function create(User $user, array $data): Task
    {
        return $user->tasks()->create($data);
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
            'total_tasks' => Task::query()->where('user_id', $user->id)->count(),
            'pending_tasks' => Task::query()->where('user_id', $user->id)->where('status', TaskStatus::Pending)->count(),
            'in_progress_tasks' => Task::query()->where('user_id', $user->id)->where('status', TaskStatus::InProgress)->count(),
            'completed_tasks' => Task::query()->where('user_id', $user->id)->where('status', TaskStatus::Completed)->count(),
        ];
    }
}
