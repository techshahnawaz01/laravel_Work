<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\AuthServiceInterface;
use App\Contracts\TaskRepositoryInterface;
use App\Contracts\TaskServiceInterface;
use App\Contracts\TenantRepositoryInterface;
use App\Contracts\TenantServiceInterface;
use App\Repositories\TaskRepository;
use App\Repositories\TenantRepository;
use App\Services\AdminAuthService;
use App\Services\TaskService;
use App\Services\TenantSchemaService;
use App\Services\TenantService;
use Illuminate\Support\ServiceProvider;

class TenantServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Bind TenantServiceInterface to TenantService
        $this->app->singleton(TenantServiceInterface::class, function ($app) {
            return new TenantService(
                $app->make(TenantRepositoryInterface::class),
                $app->make(TenantSchemaService::class)
            );
        });

        // Bind TenantRepositoryInterface to TenantRepository
        $this->app->singleton(TenantRepositoryInterface::class, function ($app) {
            return new TenantRepository(new \App\Models\Tenant());
        });

        // Bind TenantSchemaService
        $this->app->singleton(TenantSchemaService::class, TenantSchemaService::class);

        // Bind TaskServiceInterface to TaskService
        $this->app->singleton(TaskServiceInterface::class, function ($app) {
            return new TaskService(
                $app->make(TaskRepositoryInterface::class)
            );
        });

        // Bind TaskRepositoryInterface to TaskRepository
        $this->app->singleton(TaskRepositoryInterface::class, function ($app) {
            return new TaskRepository(new \App\Models\Task());
        });

        // Bind AuthServiceInterface to AdminAuthService
        $this->app->singleton(AuthServiceInterface::class, AdminAuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}