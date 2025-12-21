<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create(
            [
                'name' => 'Sales 1',
                'username' => 'sales1',
                'jabatan' => 'Sales',
                'password' => Hash::make('password'),

            ]
        );
        User::factory()->create(
            [
                'name' => 'Manager 1',
                'username' => 'manager1',
                'jabatan' => 'Manager',
                // 'email' => 'manager1@example.com',
                'password' => Hash::make('password'),

            ]
        );
    }
}
