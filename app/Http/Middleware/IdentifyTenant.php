<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantSchemaService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function __construct(
        private TenantSchemaService $tenantSchemaService
    ) {}

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Skip tenant identification for super admin routes
        if ($this->isSuperAdminRoute($request)) {
            return $next($request);
        }

        // Store original schema for fallback
        $originalSchema = config('tenant.schema_name', 'public');

        try {
            // Determine tenant from domain or subdomain
            $host = $request->getHost();
            $tenant = $this->resolveTenant($host);

            if (!$tenant) {
                Log::warning('Tenant not found', ['host' => $host]);
                abort(404, 'Tenant not found');
            }

            // Check if tenant is active
            if ($tenant->status !== \App\Enums\TenantStatus::Active) {
                Log::warning('Tenant is not active', ['tenant_id' => $tenant->id]);
                abort(403, 'Tenant is not active');
            }

            // Switch to tenant schema - all subsequent queries run here
            $this->tenantSchemaService->switchToSchema($tenant);

            // Set tenant context for application-wide access
            app()->singleton('currentTenant', fn() => $tenant);
            app()->singleton('tenant.schema_name', fn() => $tenant->schema_name);

            // Process request within tenant schema
            $response = $next($request);

            return $response;
        } catch (\Exception $e) {
            Log::error('Tenant middleware error', [
                'error' => $e->getMessage(),
                'host' => $request->getHost(),
            ]);
            throw $e;
        } finally {
            // Always switch back to public schema after request completes
            // This prevents data leakage between requests
            try {
                $this->tenantSchemaService->switchToSchema(new Tenant(['schema_name' => 'public']));
            } catch (\Exception $e) {
                Log::warning('Failed to reset schema to public', [
                    'error' => $e->getMessage(),
                ]);
            }
        }
    }

    /**
     * Resolve tenant from request host.
     */
    private function resolveTenant(string $host): ?Tenant
    {
        // Try to find by domain
        $tenant = Tenant::where('domain', $host)
            ->where('status', \App\Enums\TenantStatus::Active)
            ->first();

        if ($tenant) {
            return $tenant;
        }

        // Try to extract tenant from subdomain
        $parts = explode('.', $host);
        $tenantName = $parts[0] ?? null;

        if ($tenantName) {
            $tenant = Tenant::where('tenant_name', $tenantName)
                ->where('status', \App\Enums\TenantStatus::Active)
                ->first();

            if ($tenant) {
                return $tenant;
            }
        }

        return null;
    }

    /**
     * Check if the request is for super admin routes.
     */
    private function isSuperAdminRoute(Request $request): bool
    {
        $path = $request->path();
        $adminPrefix = config('tenant.admin_prefix', 'admin');

        return str_starts_with($path, $adminPrefix) || str_starts_with($path, 'api/admin');
    }
}