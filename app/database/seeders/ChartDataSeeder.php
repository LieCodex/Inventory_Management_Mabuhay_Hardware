<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ChartDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create fake sales transactions for the last 7 days
        $salesData = [
            ['date' => Carbon::now()->subDays(6), 'amount' => 1500.00],
            ['date' => Carbon::now()->subDays(5), 'amount' => 2200.50],
            ['date' => Carbon::now()->subDays(4), 'amount' => 1800.75],
            ['date' => Carbon::now()->subDays(3), 'amount' => 2500.00],
            ['date' => Carbon::now()->subDays(2), 'amount' => 1900.25],
            ['date' => Carbon::now()->subDays(1), 'amount' => 2100.00],
            ['date' => Carbon::now(), 'amount' => 1700.50],
        ];

        foreach ($salesData as $data) {
            DB::table('transactions')->insert([
                'total_amount' => $data['amount'],
                'transaction_date' => $data['date'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Create fake purchase data (logistic_items) for the last 7 days
        // First, ensure we have some logistic_logs
        $logisticLogs = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->subDays($i);
            $logId = DB::table('logistic_logs')->insertGetId([
                'date' => $date,
                'logistic_company' => 'Fake Supplier ' . ($i + 1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $logisticLogs[] = $logId;
        }

        $purchaseData = [
            ['log_id' => $logisticLogs[6], 'item_id' => 1, 'quantity' => 10, 'unit_cost' => 200.00, 'date' => Carbon::now()->subDays(6)],
            ['log_id' => $logisticLogs[5], 'item_id' => 2, 'quantity' => 5, 'unit_cost' => 3000.00, 'date' => Carbon::now()->subDays(5)],
            ['log_id' => $logisticLogs[4], 'item_id' => 3, 'quantity' => 20, 'unit_cost' => 100.00, 'date' => Carbon::now()->subDays(4)],
            ['log_id' => $logisticLogs[3], 'item_id' => 4, 'quantity' => 15, 'unit_cost' => 1000.00, 'date' => Carbon::now()->subDays(3)],
            ['log_id' => $logisticLogs[2], 'item_id' => 5, 'quantity' => 8, 'unit_cost' => 400.00, 'date' => Carbon::now()->subDays(2)],
            ['log_id' => $logisticLogs[1], 'item_id' => 1, 'quantity' => 12, 'unit_cost' => 220.00, 'date' => Carbon::now()->subDays(1)],
            ['log_id' => $logisticLogs[0], 'item_id' => 2, 'quantity' => 3, 'unit_cost' => 3200.00, 'date' => Carbon::now()],
        ];

        foreach ($purchaseData as $data) {
            DB::table('logistic_items')->insert([
                'logs_id' => $data['log_id'],
                'item_id' => $data['item_id'],
                'quantity' => $data['quantity'],
                'unit_cost' => $data['unit_cost'],
                'created_at' => $data['date'],
                'updated_at' => now(),
            ]);
        }
    }
}