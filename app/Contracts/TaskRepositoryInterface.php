<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateTaskDTO;
use App\DTO\UpdateTaskDTO;
use App\Enums\TaskPriority;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TaskRepositoryInterface
{
    public function all(): Collection;

    public function findById(string $id): ?Model;

    public function findByTenant(int $tenantId): Collection;

    public function findByStatus(int $tenantId, TaskStatus $status): Collection;

    public function findByPriority(int $tenantId, TaskPriority $priority): Collection;

    public function create(CreateTaskDTO $dto): Model;

    public function update(int $id, UpdateTaskDTO $dto): Model;

    public function delete(int $id): bool;

    public function markAsCompleted(int $id): Model;

    public function markAsCancelled(int $id): Model;

    public function countByTenant(int $tenantId): int;

    public function getOverdue(int $tenantId): Collection;
}
