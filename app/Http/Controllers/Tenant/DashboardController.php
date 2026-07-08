<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display tenant dashboard.
     */
    public function index(): Response
    {
        $user = Auth::guard('web')->user();

        $totalTasks = Task::where('assigned_to', $user->id)->count();
        $pendingTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'pending')
            ->count();
        $completedTasks = Task::where('assigned_to', $user->id)
            ->where('status', 'completed')
            ->count();

        return response()->view('tenant.dashboard', [
            'user' => $user,
            'stats' => [
                'total_tasks' => $totalTasks,
                'pending_tasks' => $pendingTasks,
                'completed_tasks' => $completedTasks,
            ],
        ]);
    }
}