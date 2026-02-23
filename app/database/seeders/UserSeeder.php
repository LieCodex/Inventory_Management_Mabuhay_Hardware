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
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@mabuhay.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Create Cashier
        User::create([
            'name' => 'John Cashier',
            'email' => 'cashier@mabuhay.com',
            'password' => Hash::make('password123'),
            'role' => 'cashier',
        ]);

        // Create Inventory Manager
        User::create([
            'name' => 'Sarah Manager',
            'email' => 'manager@mabuhay.com',
            'password' => Hash::make('password123'),
            'role' => 'inventory_manager',
        ]);
    }
}
