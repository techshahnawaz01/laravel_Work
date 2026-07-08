<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Support\Facades\Config;

trait TenantConnection
{
    /**
     * Boot the trait to set the tenant connection.
     */
    protected static function bootTenantConnection(): void
    {
        static::creating(function (self $model): void {
            $model->setTenantConnection();
        });

        static::retrieved(function (self $model): void {
            $model->setTenantConnection();
        });
    }

    /**
     * Set the tenant connection for the model.
     */
    public function setTenantConnection(): void
    {
        if ($schemaName = $this->getSchemaName()) {
            $connection = $this->getConnectionName() ?: config('database.default');

            config([
                "database.connections.{$connection}.search_path" => $schemaName . ',public',
            ]);
        }
    }

    /**
     * Get the schema name for the tenant.
     */
    protected function getSchemaName(): ?string
    {
        if (property_exists($this, 'schemaName') && $this->schemaName) {
            return $this->schemaName;
        }

        if (isset($this->attributes['schema_name'])) {
            return $this->attributes['schema_name'];
        }

        return null;
    }
}
