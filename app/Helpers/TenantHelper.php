<?php

declare(strict_types=1);

namespace App\Helpers;

use App\Enums\TenantStatus;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;

class TenantHelper
{
    private const CACHE_PREFIX = 'tenant_';
    private const CACHE_TTL = 3600;

    public static function generateDomain(string $name): string
    {
        $slug = Str::slug($name, '-');

        return strtolower($slug) . '.' . config('app.tenant_domain', 'saas.app');
    }

    public static function generateDatabaseName(int $tenantId): string
    {
        return sprintf('tenant_%d_%s', $tenantId, Str::random(8));
    }

    public static function isTenantActive(?string $status): bool
    {
        return $status === 'active';
    }

    public static function buildCacheKey(string $key, int $tenantId): string
    {
        return sprintf('tenant_%d_%s', $tenantId, $key);
    }

    public static function getTenantConfig(int $tenantId, array $settings = []): array
    {
        return [
            'tenant_id' => $tenantId,
            'database' => self::getDatabaseConfig($tenantId),
            'cache_prefix' => self::buildCacheKey('', $tenantId),
            'settings' => $settings,
        ];
    }

    public static function getDatabaseConfig(int $tenantId): array
    {
        return [
            'connection' => sprintf('tenant_%d', $tenantId),
            'host' => config('database.connections.tenant.host', env('DB_HOST', '127.0.0.1')),
            'port' => config('database.connections.tenant.port', env('DB_PORT', '3306')),
            'database' => sprintf('tenant_%d', $tenantId),
            'username' => config('database.connections.tenant.username', env('DB_USERNAME', 'root')),
            'password' => config('database.connections.tenant.password', env('DB_PASSWORD', '')),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ];
    }
}
