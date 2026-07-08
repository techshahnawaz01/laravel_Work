<?php

declare(strict_types=1);

namespace App\Contracts;

use App\DTO\CreateTenantDTO;
use App\DTO\UpdateTenantDTO;
use App\Enums\TenantStatus;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface TenantServiceInterface
{
    public function getAll(): Collection;

    public function findById(string $id): ?Model;

    public function findBySchemaName(string $schemaName): ?Model;

    public function findBySlug(string $slug): ?Model;

    public function getById(int $id): Model;

    public function getBySlug(string $slug): Model;

    public function getByStatus(TenantStatus $status): Collection;

    public function create(CreateTenantDTO $dto): Model;

    public function update(int $id, UpdateTenantDTO $dto): Model;

    public function delete(int $id): bool;

    public function activate(int $id): Model;

    public function deactivate(int $id): Model;

    public function suspend(int $id): Model;

    public function isSlugAvailable(string $slug): bool;

    public function initializeTenant(int $id): void;
}