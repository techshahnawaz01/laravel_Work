<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default super admin for testing
        Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);

        // Create additional test admin
        Admin::create([
            'name' => 'Test Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('test123'),
            'remember_token' => \Illuminate\Support\Str::random(10),
        ]);
    }
}