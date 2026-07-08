<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TenantSchemaService
{
    public function createSchema(Tenant $tenant): void
    {
        DB::statement(sprintf('CREATE SCHEMA IF NOT EXISTS "%s"', $tenant->schema_name));
    }

    public function dropSchema(Tenant $tenant): void
    {
        DB::statement(sprintf('DROP SCHEMA IF EXISTS "%s" CASCADE', $tenant->schema_name));
    }

    public function useTenant(Tenant $tenant): void
    {
        $this->setSearchPath($tenant->schema_name);
    }

    public function usePublicSchema(): void
    {
        $this->setSearchPath('public');
    }

    public function migrate(Tenant $tenant): void
    {
        $this->useTenant($tenant);

        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--database' => 'pgsql',
            '--force' => true,
        ]);

        $this->usePublicSchema();
    }

    public function seedOwner(Tenant $tenant, string $name, string $email, string $password): void
    {
        $this->useTenant($tenant);

        \App\Models\User::query()->updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
            ]
        );

        $this->usePublicSchema();
    }

    private function setSearchPath(string $schema): void
    {
        if (DB::getDriverName() !== 'pgsql') {
            return;
        }

        DB::statement(sprintf('SET search_path TO "%s", public', $schema));
    }
}
