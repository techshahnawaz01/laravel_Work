<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TaskServiceInterface
{
    public function getAll(int $tenantId): Collection;

    public function getById(int $id): Model;

    public function getByTenant(int $tenantId): Collection;

    public function getByStatus(int $tenantId, TaskStatus $status): Collection;

    public function getByPriority(int $tenantId, TaskPriority $priority): Collection;

    public function create(CreateTaskDTO $dto): Model;

    public function update(int $id, UpdateTaskDTO $dto): Model;

    public function delete(int $id): bool;

    public function complete(int $id): Model;

    public function cancel(int $id): Model;

    public function getOverdueTasks(int $tenantId): Collection;

    public function getTaskCount(int $tenantId): int;
}
