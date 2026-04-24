<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Execute in this specific order
        $this->call([
            UserSeeder::class,
            Inventory_ManagerSeeder::class,
        ]);
    }
}