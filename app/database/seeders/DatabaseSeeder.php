<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Users first
        $this->call(UserSeeder::class);

        // 2. Create Items/Inventory next
        $this->call(Inventory_ManagerSeeder::class);

        // 3. Create Transactions last (because they link to Items)
        $this->call(TransactionSeeder::class);

    }
}