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

        $stats = $this->taskService->statsForUser($user);
        $recentTasks = $this->taskService->recentForUser($user);

        $chartData = json_encode([
            $stats['pending_tasks'] ?? 0,
            $stats['in_progress_tasks'] ?? 0,
            $stats['completed_tasks'] ?? 0,
        ]);

        return view('tenant.dashboard', [
            'user' => $user,
            'tenant' => app('currentTenant'),
            'stats' => $stats,
            'recentTasks' => $recentTasks,
            'chartData' => $chartData,
        ]);
    }
}
