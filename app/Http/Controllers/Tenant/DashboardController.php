<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private TaskService $taskService
    ) {}

    public function index(): View
    {
        $user = Auth::guard('web')->user();

        return view('tenant.dashboard', [
            'user' => $user,
            'tenant' => app('currentTenant'),
            'stats' => $this->taskService->statsForUser($user),
            'recentTasks' => $this->taskService->recentForUser($user),
        ]);
    }
}
