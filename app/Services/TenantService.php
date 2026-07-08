<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\TenantRepositoryInterface;
use App\Contracts\TenantServiceInterface;
use App\DTO\CreateTenantDTO;
use App\DTO\UpdateTenantDTO;
use App\Enums\TenantStatus;
use App\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantService implements TenantServiceInterface
{
    public function __construct(
        private TenantRepositoryInterface $tenantRepository,
        private TenantSchemaService $schemaService
    ) {}

    /**
     * Get all tenants.
     */
    public function getAll(): Collection
    {
        return $this->tenantRepository->all();
    }

    /**
     * Find a tenant by ID.
     */
    public function findById(string $id): ?Tenant
    {
        return $this->tenantRepository->findById($id);
    }

    /**
     * Find a tenant by schema name.
     */
    public function findBySchemaName(string $schemaName): ?Tenant
    {
        return $this->tenantRepository->findBySchemaName($schemaName);
    }

    /**
     * Find a tenant by slug.
     */
    public function findBySlug(string $slug): ?Tenant
    {
        return $this->tenantRepository->findBySlug($slug);
    }

    /**
     * Find a tenant by ID (throws exception if not found).
     */
    public function getById(int $id): Tenant
    {
        $tenant = $this->findById((string) $id);

        if (!$tenant) {
            throw new \InvalidArgumentException("Tenant not found: {$id}");
        }

        return $tenant;
    }

    /**
     * Find a tenant by slug (throws exception if not found).
     */
    public function getBySlug(string $slug): Tenant
    {
        $tenant = $this->tenantRepository->findBySlug($slug);

        if (!$tenant) {
            throw new \InvalidArgumentException("Tenant not found with slug: {$slug}");
        }

        return $tenant;
    }

    /**
     * Create a new tenant with automatic schema setup.
     */
    public function create(CreateTenantDTO $dto): Tenant
    {
        return DB::transaction(function () use ($dto): Tenant {
            // Create tenant record
            $tenant = $this->tenantRepository->create($dto);

            // Create schema
            $this->schemaService->createSchema($tenant);

            // Run migrations if enabled
            if (config('tenant.auto_migrate', true)) {
                $this->schemaService->switchToSchema($tenant);
                $this->schemaService->runTenantMigrations($tenant);
                $this->schemaService->seedTenantData($tenant);
                $this->schemaService->switchToSchema(new Tenant(['schema_name' => 'public']));
            }

            return $tenant;
        });
    }

    /**
     * Update an existing tenant.
     */
    public function update(int $id, UpdateTenantDTO $dto): Tenant
    {
        $tenant = $this->tenantRepository->update($dto);

        return $tenant->fresh();
    }

    /**
     * Delete a tenant.
     */
    public function delete(int $id): bool
    {
        $tenant = $this->findById((string) $id);

        if (!$tenant) {
            return false;
        }

        // Drop tenant schema
        try {
            $this->schemaService->dropSchema($tenant);
        } catch (\Exception $e) {
            // Log error but continue with deletion
            Log::warning('Failed to drop tenant schema', [
                'tenant_id' => $id,
                'error' => $e->getMessage(),
            ]);
        }

        return $this->tenantRepository->delete((string) $id);
    }

    /**
     * Activate a tenant.
     */
    public function activate(int $id): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->activate((string) $id);

        return $tenant->fresh();
    }

    /**
     * Deactivate a tenant.
     */
    public function deactivate(int $id): Tenant
    {
        /** @var Tenant $tenant */
        $tenant = $this->tenantRepository->deactivate((string) $id);

        return $tenant->fresh();
    }

    /**
     * Suspend a tenant.
     */
    public function suspend(int $id): Tenant
    {
        return $this->deactivate($id);
    }

    /**
     * Check if a slug is available.
     */
    public function isSlugAvailable(string $slug): bool
    {
        return !$this->tenantRepository->existsBySlug($slug);
    }

    /**
     * Get tenants by status.
     */
    public function getByStatus(TenantStatus $status): Collection
    {
        return Tenant::where('status', $status)->get();
    }

    /**
     * Initialize a tenant (create schema, run migrations, seed data).
     */
    public function initializeTenant(int $id): void
    {
        $tenant = $this->findById((string) $id);

        if (!$tenant) {
            throw new \InvalidArgumentException("Tenant not found: {$id}");
        }

        // Create schema
        $this->schemaService->createSchema($tenant);

        // Switch to tenant schema
        $this->schemaService->switchToSchema($tenant);

        // Run migrations
        $this->schemaService->runTenantMigrations($tenant);

        // Seed default data
        $this->schemaService->seedTenantData($tenant);

        // Switch back to public schema
        $this->schemaService->switchToSchema(new Tenant(['schema_name' => 'public']));
    }
}