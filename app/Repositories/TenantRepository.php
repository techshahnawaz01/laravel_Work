<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\TenantRepositoryInterface;
use App\DTO\CreateTenantDTO;
use App\DTO\UpdateTenantDTO;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class TenantRepository extends BaseRepository implements TenantRepositoryInterface
{
    /**
     * Create a new TenantRepository instance.
     */
    public function __construct(Tenant $tenant)
    {
        parent::__construct($tenant);
    }

    /**
     * Find a tenant by their slug.
     */
    public function findBySlug(string $slug): ?Model
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Find a tenant by their schema name.
     */
    public function findBySchemaName(string $schemaName): ?Model
    {
        return $this->model->where('schema_name', $schemaName)->first();
    }

    /**
     * Create a new tenant.
     */
    public function create(CreateTenantDTO $dto): Model
    {
        return $this->model->create($dto->toArray());
    }

    /**
     * Update an existing tenant.
     */
    public function update(UpdateTenantDTO $dto): Model
    {
        $this->model->update($dto->toArray());

        return $this->model->fresh();
    }

    /**
     * Delete a tenant by ID.
     */
    public function delete(string $id): bool
    {
        $record = $this->model->find($id);

        if ($record === null) {
            return false;
        }

        return (bool) $record->delete();
    }

    /**
     * Activate a tenant.
     */
    public function activate(string $id): Model
    {
        $record = $this->model->findOrFail($id);
        $record->update(['status' => \App\Enums\TenantStatus::Active]);

        return $record->fresh();
    }

    /**
     * Deactivate a tenant.
     */
    public function deactivate(string $id): Model
    {
        $record = $this->model->findOrFail($id);
        $record->update(['status' => \App\Enums\TenantStatus::Inactive]);

        return $record->fresh();
    }

    /**
     * Find tenants by status.
     */
    public function findByStatus(\App\Enums\TenantStatus $status): Collection
    {
        return $this->model->where('status', $status->value)->get();
    }

    /**
     * Suspend a tenant.
     */
    public function suspend(string $id): Model
    {
        return $this->deactivate($id);
    }

    /**
     * Check if slug exists.
     */
    public function existsBySlug(string $slug): bool
    {
        return $this->model->where('slug', $slug)->exists();
    }
}
