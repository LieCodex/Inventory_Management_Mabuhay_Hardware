<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::updateOrCreate(
            ['email' => 'admin@mabuhay.com'],
            [
                'name' => 'System Admin',
                'username' => 'admin',
                'password' => Hash::make('password123'),
                'role' => 'admin',
            ],
        );

        // Create Cashier (for testing cashier dashboard)
        User::updateOrCreate(
            ['email' => 'cashier@mabuhay.com'],
            [
                'name' => 'Cashier',
                'username' => 'cashier',
                'password' => Hash::make('password123'),
                'role' => 'cashier',
            ],
        );
    }
}
