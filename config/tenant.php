<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Tenant Admin Prefix
    |--------------------------------------------------------------------------
    |
    | This prefix is used to identify routes that belong to the super admin
    | and should bypass tenant schema switching. These routes use the
    | public schema where tenant metadata is stored.
    |
    */
    'admin_prefix' => env('TENANT_ADMIN_PREFIX', 'admin'),

    /*
    |--------------------------------------------------------------------------
    | Tenant Model
    |--------------------------------------------------------------------------
    |
    | The model used to represent tenants in the application.
    |
    */
    'model' => \App\Models\Tenant::class,

    /*
    |--------------------------------------------------------------------------
    | UUID Column
    |--------------------------------------------------------------------------
    |
    | The column name on the tenants table that stores the UUID.
    |
    */
    'uuid_column' => 'uuid',

    /*
    |--------------------------------------------------------------------------
    | Schema Column
    |--------------------------------------------------------------------------
    |
    | The column name on the tenants table that stores the schema name.
    |
    */
    'schema_column' => 'schema_name',

    /*
    |--------------------------------------------------------------------------
    | Auto Migrate Tenants
    |--------------------------------------------------------------------------
    |
    | Set to true to automatically run tenant migrations when a new tenant
    | is created.
    |
    */
    'auto_migrate' => env('TENANT_AUTO_MIGRATE', true),

    /*
    |--------------------------------------------------------------------------
    | Use UUIDs
    |--------------------------------------------------------------------------
    |
    | Set to true to use UUIDs instead of auto-incrementing IDs for tenants.
    |
    */
    'use_uuids' => env('TENANT_USE_UUIDS', true),

    /*
    |--------------------------------------------------------------------------
    | Tenant Routes
    |--------------------------------------------------------------------------
    |
    | These routes are automatically prefixed with the tenant's domain
    | and use the tenant middleware.
    |
    */
    'routes' => [
        'prefix' => env('TENANT_ROUTE_PREFIX', ''),
        'middleware' => ['web', \App\Http\Middleware\IdentifyTenant::class],
    ],
];