<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(
        private TenantService $tenantService
    ) {}

    /**
     * Display the super admin dashboard.
     */
    public function index(): Response
    {
        // Get tenant statistics
        $totalTenants = $this->tenantService->getAll()->count();
        $activeTenants = $this->tenantService->getByStatus(\App\Enums\TenantStatus::Active)->count();
        $inactiveTenants = $this->tenantService->getByStatus(\App\Enums\TenantStatus::Inactive)->count();

        // Get recent tenants
        $recentTenants = $this->tenantService->getAll()->take(5);

        return response()->view('admin.dashboard', [
            'admin' => Auth::guard('admin')->user(),
            'stats' => [
                'total_tenants' => $totalTenants,
                'active_tenants' => $activeTenants,
                'inactive_tenants' => $inactiveTenants,
            ],
            'recent_tenants' => $recentTenants,
        ]);
    }
}