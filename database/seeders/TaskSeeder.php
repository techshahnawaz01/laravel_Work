<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('tenant_id', '>', 0)->get();

        if ($users->isEmpty()) {
            return;
        }

        $tasks = [
            [
                'title' => 'Complete project documentation',
                'description' => 'Write comprehensive documentation for the project including setup instructions and API docs.',
                'status' => 'in_progress',
                'due_date' => now()->addDays(7),
                'created_by' => $users[0]->id,
                'assigned_to' => $users[0]->id,
            ],
            [
                'title' => 'Review pull requests',
                'description' => 'Review and merge pending pull requests from the team.',
                'status' => 'pending',
                'due_date' => now()->addDays(3),
                'created_by' => $users[0]->id,
                'assigned_to' => $users[1]->id ?? $users[0]->id,
            ],
            [
                'title' => 'Deploy to production',
                'description' => 'Deploy the latest version to production server.',
                'status' => 'pending',
                'due_date' => now()->addDays(14),
                'created_by' => $users[0]->id,
                'assigned_to' => $users[2]->id ?? $users[0]->id,
            ],
            [
                'title' => 'Update dependencies',
                'description' => 'Update all composer and npm dependencies to latest stable versions.',
                'status' => 'completed',
                'due_date' => now()->subDays(2),
                'created_by' => $users[1]->id ?? $users[0]->id,
                'assigned_to' => $users[0]->id,
            ],
            [
                'title' => 'Write unit tests',
                'description' => 'Create comprehensive unit tests for new features.',
                'status' => 'in_progress',
                'due_date' => now()->addDays(5),
                'created_by' => $users[2]->id ?? $users[0]->id,
                'assigned_to' => $users[1]->id ?? $users[0]->id,
            ],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}