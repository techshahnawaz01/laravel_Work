<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample tenant with all required data
        $tenant = Tenant::create([
            'name' => 'Acme Corporation',
            'tenant_name' => 'acme',
            'email' => 'admin@acme.com',
            'domain' => 'acme.test',
            'schema_name' => 'tenant_acme',
            'status' => 'active',
        ]);

        // Create tenant admin user
        $tenantAdmin = User::create([
            'name' => 'Acme Admin',
            'email' => 'admin@acme.com',
            'password' => Hash::make('password'),
            'tenant_id' => $tenant->id,
        ]);

        // Create additional tenant users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@acme.com',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@acme.com',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ],
            [
                'name' => 'Bob Johnson',
                'email' => 'bob@acme.com',
                'password' => Hash::make('password'),
                'tenant_id' => $tenant->id,
            ],
        ];

        foreach ($users as $userData) {
            User::create($userData);
        }

        $this->command->info('Tenant seeded successfully!');
        $this->command->info('Tenant: Acme Corporation');
        $this->command->info('Domain: acme.test');
        $this->command->info('Admin Email: admin@acme.com');
        $this->command->info('Admin Password: password');
    }
}