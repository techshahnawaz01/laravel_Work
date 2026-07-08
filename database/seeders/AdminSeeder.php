<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::query()->updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'id' => Uuid::uuid7()->toString(),
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
            ]
        );
    }
}
