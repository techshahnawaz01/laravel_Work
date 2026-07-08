<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TenantService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private TenantService $tenantService
    ) {}

    public function index(): View
    {
        $stats = $this->tenantService->stats();
        $tenants = $this->tenantService->paginate(100);

        $statusLabels = json_encode(['Active', 'Inactive']);
        $statusData = json_encode([$stats['active'], $stats['inactive']]);

        $nameLabels = json_encode($tenants->pluck('name'));
        $createdData = json_encode($tenants->pluck('created_at')->map(fn($d) => \Carbon\Carbon::parse($d)->format('M d')));

        return view('admin.dashboard', [
            'admin' => Auth::guard('admin')->user(),
            'stats' => $stats,
            'recentTenants' => $this->tenantService->recent(),
            'chart' => [
                'statusLabels' => $statusLabels,
                'statusData' => $statusData,
                'nameLabels' => $nameLabels,
                'createdData' => $createdData,
            ],
        ]);
    }
}
