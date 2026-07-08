<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TenantSchemaService
{
    /**
     * Create a new PostgreSQL schema for a tenant.
     */
    public function createSchema(Tenant $tenant): void
    {
        $schemaName = $tenant->schema_name;

        DB::statement("CREATE SCHEMA IF NOT EXISTS \"{$schemaName}\"");

        Log::info('Tenant schema created', [
            'tenant_id' => $tenant->id,
            'schema_name' => $schemaName,
        ]);
    }

    /**
     * Drop a PostgreSQL schema for a tenant.
     */
    public function dropSchema(Tenant $tenant): void
    {
        $schemaName = $tenant->schema_name;

        DB::statement("DROP SCHEMA IF EXISTS \"{$schemaName}\" CASCADE");

        Log::info('Tenant schema dropped', [
            'tenant_id' => $tenant->id,
            'schema_name' => $schemaName,
        ]);
    }

    /**
     * Run tenant migrations on the specific schema.
     */
    public function runTenantMigrations(Tenant $tenant): void
    {
        $schemaName = $tenant->schema_name;

        config(['tenant.schema_name' => $schemaName]);

        $this->switchToSchema($tenant);

        Artisan::call('migrate', [
            '--path' => 'database/migrations/tenant',
            '--force' => true,
            '--realpath' => true,
        ]);

        Log::info('Tenant migrations completed', [
            'tenant_id' => $tenant->id,
            'schema_name' => $schemaName,
        ]);
    }

    /**
     * Seed default tenant data.
     */
    public function seedTenantData(Tenant $tenant): void
    {
        $this->switchToSchema($tenant);

        \App\Models\User::create([
            'name' => $tenant->company_name . ' Admin',
            'email' => $tenant->email,
            'password' => bcrypt('password'),
            'tenant_id' => $tenant->id,
        ]);

        Log::info('Tenant default data seeded', [
            'tenant_id' => $tenant->id,
            'schema_name' => $tenant->schema_name,
        ]);
    }

    /**
     * Switch the database search_path to the tenant schema.
     */
    public function switchToSchema(Tenant $tenant): void
    {
        $schemaName = $tenant->schema_name;
        DB::statement("SET search_path TO \"{$schemaName}\", public");

        Log::info('Switched to tenant schema', [
            'tenant_id' => $tenant->id,
            'schema_name' => $schemaName,
        ]);
    }

    /**
     * Get the current schema from search_path.
     */
    public function getCurrentSchema(): string
    {
        $result = DB::select("SHOW search_path");
        $searchPath = $result[0]->search_path ?? 'public';
        
        $schemas = explode(',', $searchPath);
        
        return trim($schemas[0], '" ');
    }
}
