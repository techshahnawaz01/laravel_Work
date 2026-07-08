<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\TaskStatus;
use App\Models\Tenant;
use App\Services\TenantSchemaService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class TenantSeeder extends Seeder
{
    public function run(TenantSchemaService $schemaService): void
    {
        $tenant = Tenant::query()->firstOrCreate(
            ['slug' => 'acme'],
            [
                'id' => Uuid::uuid7()->toString(),
                'name' => 'Acme Workspace',
                'schema_name' => 'tenant_acme',
                'status' => 'active',
            ]
        );

        $schemaService->createSchema($tenant);
        $schemaService->migrate($tenant);
        $schemaService->seedOwner($tenant, 'Acme Owner', 'owner@acme.test', 'password');

        $schemaService->useTenant($tenant);

        $userId = DB::table('users')->where('email', 'owner@acme.test')->value('id');

        if ($userId && DB::table('tasks')->count() === 0) {
            DB::table('tasks')->insert([
                [
                    'user_id' => $userId,
                    'title' => 'Launch onboarding flow',
                    'description' => 'Review the tenant dashboard and confirm all seeded data is visible.',
                    'status' => TaskStatus::Pending->value,
                    'due_date' => now()->addDays(3)->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'user_id' => $userId,
                    'title' => 'Configure team workflow',
                    'description' => 'Create your first working task list for the tenant team.',
                    'status' => TaskStatus::InProgress->value,
                    'due_date' => now()->addWeek()->toDateString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        $schemaService->usePublicSchema();
    }
}
