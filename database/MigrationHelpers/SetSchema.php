<?php

declare(strict_types=1);

namespace Database\MigrationHelpers;

use Illuminate\Support\Facades\Config;

/**
 * Trait SetSchema
 *
 * Helper trait for tenant migrations to dynamically set the schema name.
 * Usage: Set the schema name before running tenant migrations via:
 *   SetSchema::$schemaName = 'tenant_1';
 *
 * Then in each tenant migration, call $this->setTenantSchema() in up().
 */
trait SetSchema
{
    /**
     * The schema name to use for tenant migrations.
     * Set this before running tenant migrations.
     *
     * @var string|null
     */
    public static ?string $schemaName = null;

    /**
     * Get the fully qualified table name with schema prefix.
     *
     * @param string $table
     * @return string
     */
    protected function tenantTable(string $table): string
    {
        $schema = static::$schemaName;

        if (!$schema) {
            $schema = config('tenancy.current_schema');
        }

        if (!$schema) {
            return $table;
        }

        return $schema . '.' . $table;
    }

    /**
     * Set the schema search path for the tenant connection.
     */
    protected function setTenantSchema(): void
    {
        $schema = static::$schemaName;

        if (!$schema) {
            $schema = config('tenancy.current_schema');
        }

        if ($schema) {
            $connection = config('database.default');
            config([
                "database.connections.{$connection}.search_path" => $schema . ',public',
            ]);
        }
    }
}
