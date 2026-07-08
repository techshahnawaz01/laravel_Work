<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\TenantStatus;
use App\Models\Tenant;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TenantService
{
    public function __construct(
        private TenantSchemaService $schemaService
    ) {}

    public function paginate(int $perPage = 12): LengthAwarePaginator
    {
        return Tenant::query()
            ->latest()
            ->paginate($perPage);
    }

    public function findById(string $id): ?Tenant
    {
        return Tenant::query()->find($id);
    }

    public function stats(): array
    {
        return [
            'total' => Tenant::query()->count(),
            'active' => Tenant::query()->where('status', TenantStatus::Active)->count(),
            'inactive' => Tenant::query()->where('status', TenantStatus::Inactive)->count(),
        ];
    }

    public function recent(int $limit = 5)
    {
        return Tenant::query()
            ->latest()
            ->limit($limit)
            ->get();
    }

    public function create(array $data): Tenant
    {
        return DB::transaction(function () use ($data): Tenant {
            $tenant = Tenant::query()->create([
                'name' => $data['name'],
                'slug' => $data['slug'],
                'schema_name' => $data['schema_name'] ?? $this->makeSchemaName($data['slug']),
                'status' => $data['status'] ?? TenantStatus::Active,
            ]);

            $this->schemaService->createSchema($tenant);
            $this->schemaService->migrate($tenant);
            $this->schemaService->seedOwner(
                $tenant,
                $data['owner_name'],
                $data['owner_email'],
                $data['owner_password'],
            );

            return $tenant;
        });
    }

    public function update(Tenant $tenant, array $data): Tenant
    {
        $tenant->fill([
            'name' => $data['name'],
            'slug' => $data['slug'],
            'status' => $data['status'],
        ])->save();

        return $tenant->fresh();
    }

    public function activate(Tenant $tenant): Tenant
    {
        $tenant->update(['status' => TenantStatus::Active]);
        return $tenant->fresh();
    }

    public function deactivate(Tenant $tenant): Tenant
    {
        $tenant->update(['status' => TenantStatus::Inactive]);
        return $tenant->fresh();
    }

    private function makeSchemaName(string $slug): string
    {
        return 'tenant_'.Str::slug($slug, '_');
    }
}
