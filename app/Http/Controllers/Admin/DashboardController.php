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
        return view('admin.dashboard', [
            'admin' => Auth::guard('admin')->user(),
            'stats' => $this->tenantService->stats(),
            'recentTenants' => $this->tenantService->recent(),
        ]);
    }
}
