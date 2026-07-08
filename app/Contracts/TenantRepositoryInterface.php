<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateTenantDTO;
use App\DTO\UpdateTenantDTO;
use App\Enums\TenantStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TenantRepositoryInterface
{
    public function all(): Collection;

    public function findById(string $id): ?Model;

    public function findBySlug(string $slug): ?Model;

    public function findBySchemaName(string $schemaName): ?Model;

    public function findByStatus(TenantStatus $status): Collection;

    public function create(CreateTenantDTO $dto): Model;

    public function update(UpdateTenantDTO $dto): Model;

    public function delete(string $id): bool;

    public function activate(string $id): Model;

    public function deactivate(string $id): Model;

    public function suspend(string $id): Model;

    public function existsBySlug(string $slug): bool;
}
