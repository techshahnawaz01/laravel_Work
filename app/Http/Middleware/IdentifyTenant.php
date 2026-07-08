<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\Tenant;
use App\Services\TenantSchemaService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    public function __construct(
        private TenantSchemaService $tenantSchemaService
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $this->tenantSchemaService->usePublicSchema();

        $slug = $request->route('tenant');

        if (!is_string($slug) || $slug === '') {
            return $next($request);
        }

        $tenant = Tenant::query()
            ->where('slug', $slug)
            ->firstOrFail();

        if (!$tenant->status->isActive()) {
            abort(403, 'Tenant is inactive.');
        }

        $this->tenantSchemaService->useTenant($tenant);
        $request->attributes->set('currentTenant', $tenant);
        app()->instance('currentTenant', $tenant);

        try {
            return $next($request);
        } finally {
            $this->tenantSchemaService->usePublicSchema();
            app()->forgetInstance('currentTenant');
        }
    }
}
